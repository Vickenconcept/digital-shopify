<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <table role="presentation" style="width: 100%; border-collapse: collapse; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <tr>
            <td style="padding: 40px 20px;">
                
                <!-- Main Container -->
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">
                                🎉 Welcome!
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                We're excited to have you on board
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <p style="margin: 0 0 20px 0; color: #333333; font-size: 18px; line-height: 1.6;">
                                Hello! 👋
                            </p>
                            
                            <p style="margin: 0 0 30px 0; color: #666666; font-size: 16px; line-height: 1.6;">
                                Thank you for joining <strong>{{ config('app.name') }}</strong>! Your account has been successfully created, and we're thrilled to have you as part of our community.
                            </p>
                            
                            <!-- Password Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px 0;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 10px 0; color: #ffffff; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                            Your Temporary Password
                                        </p>
                                        <p style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 2px; font-family: 'Courier New', monospace; word-break: break-all;">
                                            {{ $password }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Security Notice -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px 0;">
                                <tr>
                                    <td style="background-color: #fff4e6; border-left: 4px solid #ff9800; border-radius: 8px; padding: 15px 20px;">
                                        <p style="margin: 0; color: #e65100; font-size: 14px; line-height: 1.5;">
                                            <strong>🔒 Security Tip:</strong> We recommend changing this password after your first login to ensure your account's security.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0 0 30px 0; color: #666666; font-size: 16px; line-height: 1.6;">
                                Use this password to log in to your account and start exploring all the amazing features we have to offer.
                            </p>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 30px 0;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('login') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 50px; font-size: 16px; font-weight: 600; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); transition: all 0.3s ease;">
                                            Login to Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Help Section -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 0 0 20px 0;">
                                <tr>
                                    <td style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; text-align: center;">
                                        <p style="margin: 0 0 10px 0; color: #333333; font-size: 16px; font-weight: 600;">
                                            Need Help?
                                        </p>
                                        <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                            If you have any questions or need assistance, feel free to reach out to us at<br>
                                            <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                                                {{ env('MAIL_FROM_ADDRESS') }}
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0; color: #999999; font-size: 14px; line-height: 1.6; text-align: center;">
                                If you didn't create this account, please ignore this email or contact us immediately.
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            
                            <p style="margin: 0 0 15px 0; color: #333333; font-size: 16px; font-weight: 600;">
                                Welcome to {{ config('app.name') }}! 🚀
                            </p>
                            
                            <p style="margin: 0 0 20px 0; color: #666666; font-size: 14px; line-height: 1.6;">
                                We're here to help you every step of the way.
                            </p>
                            
                            <!-- Social Links (Optional - you can customize or remove) -->
                            <table role="presentation" style="margin: 0 auto 20px auto; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <a href="{{ route('home') }}" style="color: #667eea; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            Visit Website
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0; color: #999999; font-size: 12px; line-height: 1.5;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                                This email was sent to you as a registered user of {{ config('app.name') }}.
                            </p>
                            
                        </td>
                    </tr>
                    
                </table>
                
            </td>
        </tr>
    </table>

</body>
</html>
