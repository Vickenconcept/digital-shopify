<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function __construct(
        private readonly ActivityLogger $activityLogger,
    ) {}

    /**
     * Display a listing of admin users.
     */
    public function index(Request $request)
    {
        // Only super-admin can access
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized access.');
        }

        $query = User::with('roles')
            ->whereHas('roles', function($roleQuery) {
                $roleQuery->whereIn('name', ['admin', 'super-admin']);
            });

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Apply role filter
        if ($request->has('role') && $request->role) {
            $query->whereHas('roles', function($roleQuery) use ($request) {
                $roleQuery->where('name', $request->role);
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'email':
                $query->orderBy('email');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $admins = $query->paginate(15)->withQueryString();

        return view('admin.admin-users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        // Only super-admin can access
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.admin-users.create');
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        // Only super-admin can access
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        // Generate a random password
        $rawPassword = Str::random(12);
        
        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($rawPassword),
            'email_verified_at' => now(),
        ]);

        // Assign admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($adminRole);

        // Send welcome email with password
        try {
            Mail::to($user->email)->send(new WelcomeMail($rawPassword));
        } catch (\Exception $e) {
            Log::error('Failed to send admin welcome email: ' . $e->getMessage());
        }

        return redirect()->route('admin.admin-users.index')
            ->with('success', "Admin user '{$user->name}' created successfully. Welcome email sent to {$user->email}");
    }

    /**
     * Display the specified admin user.
     */
    public function show(User $adminUser)
    {
        // Only super-admin can access
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized access.');
        }

        // Check if user is actually an admin
        if (!$adminUser->hasRole(['admin', 'super-admin'])) {
            abort(404, 'Admin user not found.');
        }

        $adminUser->load(['roles', 'orders', 'digitalProducts', 'blogs']);
        return view('admin.admin-users.show', compact('adminUser'));
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $adminUser)
    {
        // Only super-admin can access
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized access.');
        }

        // Prevent deleting yourself
        if ($adminUser->id === auth()->id()) {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting other super-admins
        if ($adminUser->hasRole('super-admin')) {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'You cannot delete a super-admin account.');
        }

        $adminName = $adminUser->name;
        $adminEmail = $adminUser->email;
        $adminUser->delete();

        $this->activityLogger->log(
            ActivityLog::LOG_ADMIN,
            'deleted',
            "Admin user deleted: {$adminName}",
            properties: ['email' => $adminEmail]
        );

        return redirect()->route('admin.admin-users.index')
            ->with('success', "Admin user '{$adminName}' deleted successfully.");
    }
}

