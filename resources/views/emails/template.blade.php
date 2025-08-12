<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .email-header {
            background-color: #1a365d;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 4px 4px 0 0;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        /* Content */
        .email-content {
            background-color: #ffffff;
            padding: 30px;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f7fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 4px 4px;
        }
        
        .email-footer a {
            color: #4299e1;
            text-decoration: none;
        }
        
        .email-footer a:hover {
            text-decoration: underline;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .email-content,
            .email-header,
            .email-footer {
                padding: 15px !important;
            }
        }
        
        /* Button styles */
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4299e1;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            color: #2d3748;
        }
        
        p {
            margin-bottom: 1em;
        }
        
        /* Utility classes */
        .text-center {
            text-align: center;
        }
        
        .mt-0 { margin-top: 0; }
        .mb-0 { margin-bottom: 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ config('app.name', 'Email Automation') }}</h1>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            @if(isset($data['greeting']))
                <p>Hello {{ $data['name'] ?? 'there' }},</p>
            @endif
            
            {!! $content !!}
            
            @if(isset($data['button_url']) && isset($data['button_text']))
                <p class="text-center">
                    <a href="{{ $data['button_url'] }}" class="button">
                        {{ $data['button_text'] }}
                    </a>
                </p>
            @endif
            
            @if(!isset($data['no_signature']) || $data['no_signature'] === false)
                <p>Best regards,<br>The {{ config('app.name', 'Email Automation') }} Team</p>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Email Automation') }}. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url', '#') }}">Website</a> | 
                <a href="{{ config('app.url', '#') }}/privacy">Privacy Policy</a> | 
                <a href="{{ config('app.url', '#') }}/unsubscribe">Unsubscribe</a>
            </p>
            <p class="mt-0">
                {{ config('app.name', 'Email Automation') }}<br>
                {{ config('app.address', '123 Business St, City, Country') }}
            </p>
        </div>
    </div>
</body>
</html>
