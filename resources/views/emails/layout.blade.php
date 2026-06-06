<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">
                <tr>
                    <td style="background:linear-gradient(135deg,#f97316,#ea580c);padding:28px 32px;text-align:center;">
                        <p style="margin:0;color:#fff;font-size:13px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">Your Journey Voices</p>
                        <h1 style="margin:8px 0 0;color:#fff;font-size:22px;font-weight:700;">@yield('heading')</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        @yield('content')
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 32px;background:#f9fafb;border-top:1px solid #e5e7eb;text-align:center;">
                        <p style="margin:0;color:#6b7280;font-size:13px;line-height:1.5;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. Stories That Travel With You.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
