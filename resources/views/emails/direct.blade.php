<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from Central Bank of Kenya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }
        .header {
            background-color: #1a365d;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 200px;
            height: auto;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1a365d;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://www.centralbank.go.ke/wp-content/uploads/2016/09/NewLogoCBK.png" alt="Central Bank of Kenya">
        </div>
        
        <div class="content">
            <p class="greeting">Dear {{ $client->name }},</p>
            
            <div class="message">
                {!! nl2br(e($content)) !!}
            </div>
            
            <p>Thank you for your continued partnership with Central Bank of Kenya.</p>
            
            <p>Warm regards,<br>
            Central Bank of Kenya Team</p>
        </div>
        
        <div class="footer">
            <p>Central Bank of Kenya<br>
            Haile Selassie Avenue, Nairobi, Kenya<br>
            P.O. Box 60000 - 00200, Nairobi, Kenya<br>
            Tel: +254 20 286 0000 | Email: info@centralbank.go.ke</p>
            
            <p>This is an automated message. Please do not reply to this email.</p>
            
            <p>© {{ date('Y') }} Central Bank of Kenya. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
