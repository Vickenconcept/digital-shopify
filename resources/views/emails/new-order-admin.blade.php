@extends('emails.layout')

@section('title', 'New Order #' . $order->id)
@section('heading', 'New order received')

@section('content')
    <p style="margin:0 0 20px;color:#6b7280;font-size:15px;line-height:1.6;">
        A customer completed checkout on {{ config('app.name') }}.
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
        <tr>
            <td style="padding:8px 0;color:#6b7280;font-size:14px;width:120px;">Order ID</td>
            <td style="padding:8px 0;color:#111827;font-size:14px;font-weight:600;">#{{ $order->id }}</td>
        </tr>
        <tr>
            <td style="padding:8px 0;color:#6b7280;font-size:14px;">Customer</td>
            <td style="padding:8px 0;color:#111827;font-size:14px;">{{ $order->user->name }}</td>
        </tr>
        <tr>
            <td style="padding:8px 0;color:#6b7280;font-size:14px;">Email</td>
            <td style="padding:8px 0;color:#111827;font-size:14px;">
                <a href="mailto:{{ $order->user->email }}" style="color:#f97316;">{{ $order->user->email }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0;color:#6b7280;font-size:14px;">Total</td>
            <td style="padding:8px 0;color:#f97316;font-size:16px;font-weight:800;">${{ number_format($order->total_amount, 2) }}</td>
        </tr>
        @if($order->paid_at)
            <tr>
                <td style="padding:8px 0;color:#6b7280;font-size:14px;">Paid at</td>
                <td style="padding:8px 0;color:#111827;font-size:14px;">{{ $order->paid_at->format('F j, Y g:i A') }}</td>
            </tr>
        @endif
    </table>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:24px;border:1px solid #e5e7eb;border-radius:8px;">
        @foreach($order->items as $item)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:10px 14px;font-size:14px;color:#374151;">
                    {{ $item->product->title ?? 'Product' }} ({{ $item->quantity }}&times;)
                </td>
                <td style="padding:10px 14px;text-align:right;font-size:14px;font-weight:600;">
                    ${{ number_format($item->price * $item->quantity, 2) }}
                </td>
            </tr>
        @endforeach
    </table>

    <table role="presentation" cellspacing="0" cellpadding="0">
        <tr>
            <td style="border-radius:8px;background:#111827;">
                <a href="{{ url('/admin/orders/' . $order->id) }}" style="display:inline-block;padding:12px 24px;color:#fff;font-size:14px;font-weight:600;text-decoration:none;">
                    View order in admin
                </a>
            </td>
        </tr>
    </table>
@endsection
