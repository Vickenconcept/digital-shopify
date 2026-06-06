@extends('emails.layout')

@section('title', 'Welcome')
@section('heading', 'Welcome aboard!')

@section('content')
    <p style="margin:0 0 16px;color:#374151;font-size:16px;line-height:1.6;">
        Hi {{ $user->name }},
    </p>
    <p style="margin:0 0 24px;color:#6b7280;font-size:15px;line-height:1.6;">
        Thanks for creating your account at <strong>{{ config('app.name') }}</strong>. Please verify your email address (check your inbox for the verification link) before checkout and downloading purchased content.
    </p>

    <table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto 16px;">
        <tr>
            <td style="border-radius:8px;background:#f97316;">
                <a href="{{ route('login') }}" style="display:inline-block;padding:14px 28px;color:#fff;font-size:15px;font-weight:600;text-decoration:none;">
                    Sign in to your account
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:0;color:#9ca3af;font-size:13px;line-height:1.5;text-align:center;">
        If you did not create this account, please contact us immediately.
    </p>
@endsection
