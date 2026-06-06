@extends('emails.layout')

@section('title', 'Order Confirmation #' . $order->id)
@section('heading', 'Thank you for your purchase!')

@section('content')
    <p style="margin:0 0 16px;color:#374151;font-size:16px;line-height:1.6;">
        Hi {{ $order->user->name }},
    </p>
    <p style="margin:0 0 24px;color:#6b7280;font-size:15px;line-height:1.6;">
        Your payment was successful. Here is a summary of order <strong>#{{ $order->id }}</strong>.
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:24px;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
        <tr style="background:#fff7ed;">
            <td colspan="2" style="padding:12px 16px;font-size:13px;font-weight:700;color:#c2410c;text-transform:uppercase;">Order items</td>
        </tr>
        @foreach($order->items as $item)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px 16px;color:#111827;font-size:14px;">
                    {{ $item->product->title ?? 'Product' }}
                    <span style="color:#6b7280;"> &times; {{ $item->quantity }}</span>
                </td>
                <td style="padding:12px 16px;text-align:right;color:#111827;font-size:14px;font-weight:600;">
                    ${{ number_format($item->price * $item->quantity, 2) }}
                </td>
            </tr>
        @endforeach
        <tr style="border-top:1px solid #e5e7eb;">
            <td style="padding:10px 16px;color:#374151;font-size:14px;">Subtotal</td>
            <td style="padding:10px 16px;text-align:right;color:#374151;font-size:14px;">
                ${{ number_format($receipt['subtotal'], 2) }}
            </td>
        </tr>
        <tr>
            <td style="padding:10px 16px;color:#374151;font-size:14px;">
                Tax@if($receipt['tax_rate'] > 0) ({{ number_format($receipt['tax_rate'], 2) }}%)@endif
            </td>
            <td style="padding:10px 16px;text-align:right;color:#374151;font-size:14px;">
                ${{ number_format($receipt['tax_amount'], 2) }}
            </td>
        </tr>
        <tr style="background:#f9fafb;border-top:2px solid #e5e7eb;">
            <td style="padding:14px 16px;font-size:15px;font-weight:700;color:#111827;">Total paid</td>
            <td style="padding:14px 16px;text-align:right;font-size:18px;font-weight:800;color:#f97316;">
                ${{ number_format($order->total_amount, 2) }}
            </td>
        </tr>
    </table>

    @if($order->paid_at)
        <p style="margin:0 0 24px;color:#6b7280;font-size:14px;">
            Paid on {{ $order->paid_at->format('F j, Y \a\t g:i A') }}
        </p>
    @endif

    <p style="margin:0 0 16px;color:#6b7280;font-size:13px;line-height:1.5;text-align:center;">
        A PDF receipt is attached to this email for your records.
    </p>

    <table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:8px;background:#f97316;">
                <a href="{{ route('user.orders') }}" style="display:inline-block;padding:14px 28px;color:#fff;font-size:15px;font-weight:600;text-decoration:none;">
                    View my orders &amp; downloads
                </a>
            </td>
        </tr>
    </table>
@endsection
