<?php

namespace App\Services;

use App\Mail\NewUserAdminMail;
use App\Mail\UserWelcomeMail;
use App\Models\ActivityLog;
use App\Models\User;
use App\Support\AdminNotifications;
use App\Support\MailRecipients;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserMailService
{
    public function __construct(
        private readonly ActivityLogger $activityLogger,
    ) {}

    public function sendRegistrationNotifications(User $user): void
    {
        try {
            Mail::to($user->email)->send(new UserWelcomeMail($user));
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'sent',
                "Welcome email sent to {$user->email}",
                $user,
                properties: ['template' => 'user_welcome']
            );
        } catch (\Throwable $e) {
            Log::error('User welcome email failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'failed',
                "Welcome email failed for {$user->email}",
                $user,
                properties: ['error' => $e->getMessage()]
            );
        }

        if (AdminNotifications::isEnabled('new_user')) {
            try {
                Mail::to(MailRecipients::admin())->send(new NewUserAdminMail($user));
                $this->activityLogger->log(
                    ActivityLog::LOG_EMAIL,
                    'sent',
                    "Admin notified of new user: {$user->email}",
                    $user,
                    properties: ['template' => 'new_user_admin']
                );
            } catch (\Throwable $e) {
                Log::error('Admin new user email failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
                $this->activityLogger->log(
                    ActivityLog::LOG_EMAIL,
                    'failed',
                    "Admin new-user email failed for registration: {$user->email}",
                    $user,
                    properties: ['error' => $e->getMessage()]
                );
            }
        }
    }
}
