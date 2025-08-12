<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 5px 5px; }
        .button { display: inline-block; background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome, {{ $name }}!</h1>
    </div>
    <div class="content">
        <p>Dear {{ $name }},</p>
        <p>Thank you for joining us. We're excited to have you on board!</p>
        <p>Here are your account details:</p>
        <ul>
            <li>Email: {{ $email }}</li>
            <li>Phone: {{ $phone ?? 'Not provided' }}</li>
        </ul>
        <a href="{{ $actionUrl }}" class="button">Get Started</a>
        <p>If you have any questions, feel free to contact our support team.</p>
        <p>Best regards,<br>The Team</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} Central Bank of Kenya. All rights reserved.</p>
        <p>If you didn't create an account, please ignore this email.</p>
    </div>
</body>
</html>
