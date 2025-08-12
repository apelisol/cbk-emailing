<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - CBK Email Automation</title>
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
            max-width: 400px;
            margin: 0 auto;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            color: #1f2937;
        }
        .auth-header p {
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }
        .auth-body {
            background: white;
            padding: 2.5rem;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            outline: none;
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
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }
        .auth-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-link:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .status-message {
            background-color: #ecfdf5;
            color: #065f46;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Reset Password</h1>
            <p>Enter your email address and we'll send you a link to reset your password.</p>
        </div>
        
        <div class="auth-body">
            @if(session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" 
                           class="form-control" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn">
                    Send Password Reset Link
                </button>

                <div class="auth-footer">
                    <a href="{{ route('login') }}" class="auth-link">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
