<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\UserMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserMailService $userMailService,
        private readonly ActivityLogger $activityLogger,
    ) {}

    public function register(CreateUserRequest $request)
    {
        if (!empty($request->input('website'))) {
            return redirect()->route('register')->with('success', 'Account created! Please check your email to verify your address.');
        }

        $requestData = $request->validated();

        $user = User::create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'password' => Hash::make($requestData['password']),
        ]);

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $user->assignRole($customerRole);

        $this->activityLogger->log(
            ActivityLog::LOG_AUTH,
            'registered',
            "New user registered: {$user->email}",
            $user,
            $user
        );

        Auth::login($user);
        $user->sendEmailVerificationNotification();
        $this->userMailService->sendRegistrationNotifications($user);

        return redirect()
            ->route('verification.notice')
            ->with('success', 'Account created! Please verify your email before checkout.');
    }

    public function login(CreateUserRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            $this->activityLogger->log(
                ActivityLog::LOG_AUTH,
                'login_failed',
                "Failed login attempt for {$request->email}",
                properties: ['email' => $request->email]
            );

            return $request->wantsJson()
                ? Response::api('Invalid Credentials', Response::HTTP_BAD_REQUEST)
                : back()->with('error', 'Invalid Credentials');
        }

        $user = auth()->user();

        $this->activityLogger->log(
            ActivityLog::LOG_AUTH,
            'login',
            'User logged in: ' . $user->email,
            $user,
            $user
        );

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $this->activityLogger->log(
                ActivityLog::LOG_AUTH,
                'logout',
                "User logged out: {$user->email}",
                $user,
                $user
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
