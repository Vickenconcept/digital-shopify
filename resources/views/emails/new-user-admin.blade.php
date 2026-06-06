@extends('emails.layout')

@section('title', 'New user registered')
@section('heading', 'New customer account')

@section('content')
    <p style="margin:0 0 20px;color:#6b7280;font-size:15px;line-height:1.6;">
        Someone just registered on {{ config('app.name') }}.
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:24px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">
        <tr>
            <td style="padding:14px 16px;color:#6b7280;font-size:13px;width:100px;">Name</td>
            <td style="padding:14px 16px;color:#111827;font-size:15px;font-weight:600;">{{ $user->name }}</td>
        </tr>
        <tr>
            <td style="padding:14px 16px;color:#6b7280;font-size:13px;border-top:1px solid #e5e7eb;">Email</td>
            <td style="padding:14px 16px;border-top:1px solid #e5e7eb;">
                <a href="mailto:{{ $user->email }}" style="color:#f97316;font-size:15px;">{{ $user->email }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 16px;color:#6b7280;font-size:13px;border-top:1px solid #e5e7eb;">Registered</td>
            <td style="padding:14px 16px;color:#111827;font-size:14px;border-top:1px solid #e5e7eb;">
                {{ $user->created_at?->format('F j, Y g:i A') ?? now()->format('F j, Y g:i A') }}
            </td>
        </tr>
    </table>

    <table role="presentation" cellspacing="0" cellpadding="0">
        <tr>
            <td style="border-radius:8px;background:#111827;">
                <a href="{{ url('/admin/users/' . $user->id) }}" style="display:inline-block;padding:12px 24px;color:#fff;font-size:14px;font-weight:600;text-decoration:none;">
                    View user in admin
                </a>
            </td>
        </tr>
    </table>
@endsection
