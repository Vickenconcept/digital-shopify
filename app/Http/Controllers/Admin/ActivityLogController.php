<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    private function filteredQuery(Request $request)
    {
        $query = ActivityLog::query()->with(['causer', 'subject'])->latest('created_at');

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('event')) {
            $query->where('event', 'like', '%' . $request->event . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    public function index(Request $request): View
    {
        $logs = $this->filteredQuery($request)->paginate(25)->withQueryString();

        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'orders' => ActivityLog::where('log_name', ActivityLog::LOG_ORDER)->count(),
            'auth' => ActivityLog::where('log_name', ActivityLog::LOG_AUTH)->count(),
        ];

        $logNames = ActivityLog::query()
            ->select('log_name')
            ->distinct()
            ->orderBy('log_name')
            ->pluck('log_name');

        return view('admin.activity.index', compact('logs', 'stats', 'logNames'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = $this->filteredQuery($request);
        $filename = 'activity-logs-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Category', 'Event', 'Description', 'Causer', 'IP', 'Created At']);

            $query->chunk(500, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->log_name,
                        $log->event,
                        $log->description,
                        $log->causer?->email,
                        $log->ip_address,
                        $log->created_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
