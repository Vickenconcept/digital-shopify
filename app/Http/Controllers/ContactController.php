<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
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
        $adminEmail = config('mail.contact_recipient', config('mail.from.address'));

        // Send email using the ContactMail mailable
        Mail::to($adminEmail)->send(new ContactMail(
            $validated['name'],
            $validated['email'],
            $validated['subject'],
            $validated['message']
        ));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    public function newsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:newsletter_subscriptions,email',
        ]);

        NewsletterSubscription::create([
            'email' => $validated['email'],
            'subscribed_at' => now(),
        ]);

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
