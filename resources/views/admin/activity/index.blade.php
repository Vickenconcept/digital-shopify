<x-admin-layout>
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">System Activity</h1>
            <p class="text-sm text-gray-500 mt-1">Audit trail of signups, orders, payments, emails, admin changes, and contact messages.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.activity.export', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600">
                <i class="bx bx-download"></i> Export CSV
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bx bx-arrow-back"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">All events</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Today</p>
            <p class="text-3xl font-bold text-orange-500 mt-1">{{ number_format($stats['today']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Order events</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($stats['orders']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Auth events</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($stats['auth']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-3">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Description or event…"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <div class="w-full lg:w-40">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                    <select name="log_name" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                        <option value="">All categories</option>
                        @foreach($logNames as $name)
                            <option value="{{ $name }}" @selected(request('log_name') === $name)>
                                {{ ucfirst($name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full lg:w-36">
                    <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <div class="w-full lg:w-36">
                    <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700">Filter</button>
                    @if(request()->hasAny(['search', 'log_name', 'date_from', 'date_to']))
                        <a href="{{ route('admin.activity.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">When</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                        @php
                            $badge = match($log->badge_color) {
                                'green' => 'bg-green-50 text-green-700 border-green-200',
                                'blue' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'orange' => 'bg-orange-50 text-orange-700 border-orange-200',
                                'purple' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'pink' => 'bg-pink-50 text-pink-700 border-pink-200',
                                'red' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-gray-50 text-gray-600 border-gray-200',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $log->created_at->format('M j, Y') }}</span>
                                <span class="block text-xs text-gray-500">{{ $log->created_at->format('g:i A') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold border {{ $badge }}">
                                    {{ $log->log_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded">{{ $log->event }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 max-w-md">{{ $log->description }}</p>
                                @if($log->properties && count($log->properties))
                                    <p class="text-xs text-gray-500 mt-1">
                                        @foreach(collect($log->properties)->take(3) as $key => $val)
                                            <span class="mr-2">{{ $key }}: {{ is_scalar($val) ? $val : json_encode($val) }}</span>
                                        @endforeach
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($log->causer)
                                    <span class="text-sm text-gray-900">{{ $log->causer->name ?? $log->causer->email }}</span>
                                @else
                                    <span class="text-sm text-gray-400">System / Guest</span>
                                @endif
                                @if($log->ip_address)
                                    <span class="block text-xs text-gray-400">{{ $log->ip_address }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                <p class="font-medium text-gray-700">No activity recorded yet</p>
                                <p class="text-sm mt-1">Events will appear here as users register, purchase, and admins make changes.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">What gets logged</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm text-gray-600">
            <div><span class="font-medium text-gray-800">Auth</span> — Registration, login</div>
            <div><span class="font-medium text-gray-800">Orders</span> — Checkout started, completed, failed</div>
            <div><span class="font-medium text-gray-800">Email</span> — Notifications sent to customer &amp; admin</div>
            <div><span class="font-medium text-gray-800">Contact</span> — Contact form submissions</div>
            <div><span class="font-medium text-gray-800">Products / Blog / Pages</span> — Create, update, delete</div>
            <div><span class="font-medium text-gray-800">Settings</span> — Site settings updates</div>
        </div>
    </div>

</div>
</x-admin-layout>
