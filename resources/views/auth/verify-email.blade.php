<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - CBK Email Automation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .auth-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 1rem 0;
            color: #1f2937;
        }
        .auth-message {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .auth-message p {
            color: #4b5563;
            line-height: 1.6;
            margin: 0 0 1.5rem 0;
            font-size: 1rem;
        }
        .status-message {
            background-color: #ecfdf5;
            color: #065f46;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9375rem;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: all 0.2s;
            margin-bottom: 1rem;
            text-align: center;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .btn-outline {
            background: white;
            color: #4f46e5;
            border: 1px solid #e5e7eb;
        }
        .btn-outline:hover {
            background: #f9fafb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .auth-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Verify Your Email</h1>
        </div>
        
        <div class="auth-message">
            @if (session('status') == 'verification-link-sent')
                <div class="status-message">
                    A new verification link has been sent to your email address.
                </div>
            @endif
            
            <p>Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive the email, we'll be happy to send you another one.</p>
            
            <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom: 1rem;">
                @csrf
                <button type="submit" class="btn">
                    Resend Verification Email
                </button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline">
                    Log Out
                </button>
            </form>
        </div>
        
        <div class="auth-footer">
            Need help? <a href="#" class="auth-link">Contact Support</a>
        </div>
    </div>
</body>
</html>
