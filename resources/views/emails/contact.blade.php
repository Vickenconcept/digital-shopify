<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Message</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #f97316;
        }
        .field-label {
            font-weight: 600;
            color: #f97316;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .field-value {
            color: #333;
            font-size: 16px;
        }
        .message-content {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin-top: 10px;
            white-space: pre-wrap;
            font-family: inherit;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .timestamp {
            background-color: #f3f4f6;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Message</h1>
        </div>

        <div class="timestamp">
            Received on {{ now()->format('F j, Y \a\t g:i A') }}
        </div>

        <div class="field">
            <div class="field-label">From</div>
            <div class="field-value">{{ $name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $email }}" style="color: #f97316; text-decoration: none;">{{ $email }}</a>
            </div>
        </div>

        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value">{{ $subject }}</div>
        </div>

                 <div class="field">
             <div class="field-label">Message</div>
             <div class="message-content">{{ $messageContent }}</div>
         </div>

        <div class="footer">
            <p>This message was sent from the contact form on your website.</p>
            <p>You can reply directly to this email to respond to {{ $name }}.</p>
        </div>
    </div>
</body>
</html>
