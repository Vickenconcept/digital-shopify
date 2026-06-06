<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use App\Support\AdminNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct(
        private readonly ActivityLogger $activityLogger,
    ) {}
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        // Honeypot check - if the hidden website field is filled, it's likely spam
        if (!empty($request->input('website'))) {
            // Silently reject the form submission
            return back()->with('success', 'Thank you for your message. We will get back to you soon!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Get the admin email from config or use a default
        $adminEmail = \App\Support\MailRecipients::admin();

        // Send email using the ContactMail mailable
        if (AdminNotifications::isEnabled('contact')) {
            Mail::to($adminEmail)->send(new ContactMail(
                $validated['name'],
                $validated['email'],
                $validated['subject'],
                $validated['message']
            ));

            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'sent',
                "Contact form email queued for admin from {$validated['email']}",
                properties: ['subject' => $validated['subject']]
            );
        }

        $this->activityLogger->log(
            ActivityLog::LOG_CONTACT,
            'submitted',
            "Contact form submitted: {$validated['subject']}",
            properties: [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
            ]
        );

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
