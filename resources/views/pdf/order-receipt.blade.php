<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { border-bottom: 2px solid #f97316; padding-bottom: 12px; margin-bottom: 20px; }
        .brand { font-size: 20px; font-weight: bold; color: #f97316; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #fff7ed; font-size: 11px; text-transform: uppercase; }
        .totals td { border: none; }
        .totals .label { text-align: right; padding-right: 12px; }
        .grand { font-size: 16px; font-weight: bold; color: #f97316; }
        .meta { color: #6b7280; font-size: 11px; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">{{ config('app.name') }}</div>
        <div class="meta">Order Receipt / Invoice</div>
    </div>

    <table style="border: none; margin: 0;">
        <tr>
            <td style="border: none; width: 50%; vertical-align: top;">
                <strong>Bill to</strong><br>
                {{ $order->user->name }}<br>
                {{ $order->user->email }}
            </td>
            <td style="border: none; width: 50%; vertical-align: top; text-align: right;">
                <strong>Receipt #{{ $order->id }}</strong><br>
                Date: {{ ($order->paid_at ?? $order->created_at)->format('M j, Y g:i A') }}<br>
                Payment: {{ ucfirst($order->payment_method ?? 'card') }}<br>
                Status: {{ ucfirst($order->payment_status) }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Unit</th>
                <th style="text-align:right;">Line total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->title ?? 'Product' }}</td>
                    <td style="text-align:center;">{{ $item->quantity }}</td>
                    <td style="text-align:right;">${{ number_format($item->price, 2) }}</td>
                    <td style="text-align:right;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals" style="width: 280px; margin-left: auto; margin-top: 12px;">
        <tr>
            <td class="label">Subtotal</td>
            <td style="text-align:right;">${{ number_format($receipt['subtotal'], 2) }}</td>
        </tr>
        <tr>
            <td class="label">Tax @if($receipt['tax_rate'] > 0)({{ number_format($receipt['tax_rate'], 2) }}%)@endif</td>
            <td style="text-align:right;">${{ number_format($receipt['tax_amount'], 2) }}</td>
        </tr>
        <tr>
            <td class="label grand">Total</td>
            <td class="grand" style="text-align:right;">${{ number_format($receipt['total'], 2) }}</td>
        </tr>
    </table>

    <p class="meta" style="margin-top: 24px;">Thank you for your purchase. Keep this receipt for your records.</p>
</body>
</html>
