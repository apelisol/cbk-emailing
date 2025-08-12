<!DOCTYPE html>
<html>
<head>
    <title>403 Forbidden</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 28rem;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1f2937;
        }
        p {
            color: #6b7280;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        .links {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
        }
        .btn-primary {
            background-color: #4f46e5;
            color: white;
        }
        .btn-primary:hover {
            background-color: #4338ca;
        }
        .btn-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h1>Access Restricted</h1>
        <p>You don't have permission to access this page. Please use the links below to continue.</p>
        <div class="links">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        </div>
    </div>
</body>
</html>
