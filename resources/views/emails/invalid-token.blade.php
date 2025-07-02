<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invalid Token - Email Verification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        h1 {
            color: #2d3748;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-details {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .error-details h3 {
            color: #e53e3e;
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-details ul {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-left: 20px;
        }

        .error-details li {
            margin-bottom: 5px;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.8);
            color: #4a5568;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .help-text {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .help-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .help-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .btn {
                padding: 12px 24px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        
        <h1>Invalid Token</h1>
        <p class="subtitle">The email verification link you clicked is no longer valid or has expired.</p>
        
        <div class="error-details">
            <h3>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                Common reasons:
            </h3>
            <ul>
                <li>The link has expired (typically valid for 24 hours)</li>
                <li>You've already used this verification link</li>
                <li>The link was corrupted during copy/paste</li>
                <li>Your email has already been verified</li>
            </ul>
        </div>
        
        <div class="actions">
        

{{-- <form method="POST" action="{{ route('resend-verification') }}">
    @csrf

    <div class="mb-3">
        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
    </div>

    <button type="submit" class="btn btn-primary d-flex align-items-center">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
        Request New Verification Email
    </button>
</form> --}}

<form method="POST" action="{{ route('resend-verification') }}" class="verification-form">
    @csrf
    <div class="mb-4">
        <label for="email" class="form-label fw-semibold text-dark mb-2">
            Email Address
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-muted">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.89 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
            </span>
            <input 
                type="email" 
                id="email"
                name="email" 
                class="form-control border-start-0 ps-0" 
                required 
                placeholder="Enter your email address"
                style="border-left: none !important; box-shadow: none !important;"
            >
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center py-3">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
        <span class="fw-semibold">Request New Verification Email</span>
    </button>
</form>

<style>
.verification-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 2rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.form-control {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 16px;
    transition: all 0.2s ease;
    background-color: #fff;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background-color: #fff;
}

.input-group-text {
    border: 2px solid #e5e7eb;
    border-right: none;
    border-radius: 8px 0 0 8px;
    background-color: #f8f9fa;
}

.input-group .form-control {
    border-radius: 0 8px 8px 0;
}

.input-group:focus-within .input-group-text {
    border-color: #3b82f6;
}

.input-group:focus-within .form-control {
    border-color: #3b82f6;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

.form-label {
    color: #374151;
    font-size: 14px;
}

@media (max-width: 480px) {
    .verification-form {
        margin: 1rem;
        padding: 1.5rem;
    }
}
</style>


            <a href="{{route('index')}}" class="btn btn-secondary" onclick="goToLogin()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Go to Home
            </a>
        </div>
        
        <div class="help-text">
            <p>Still having trouble? <a href="#" onclick="contactSupport()">Contact our support team</a> for assistance.</p>
        </div>
    </div>

    <script>
        function requestNewToken() {
            // Show loading state
            const btn = event.target.closest('.btn-primary');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="animation: spin 1s linear infinite;"><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/></svg> Sending...';
            btn.style.pointerEvents = 'none';
            
            // Simulate API call
            setTimeout(() => {
                alert('New verification email sent! Please check your inbox.');
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }, 2000);
        }
        
        function goToLogin() {
            // Replace with actual login URL
            window.location.href = '/';
        }
        
        function contactSupport() {
            // Replace with actual support URL or email
            window.location.href = 'mailto:support@yourcompany.com';
        }

        // Add CSS for spin animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>