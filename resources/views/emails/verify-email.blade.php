<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - CN_Nest Analytics</title>
</head>
<body style="background-color: #f1f5f9; font-family: sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: auto; background-color: white; padding: 32px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #1e3a8a; font-size: 24px; margin-bottom: 16px;">Welcome to CN_Nest Analytics</h2>

        <p style="font-size: 16px; color: #334155; margin-bottom: 16px;">
            Hi <strong>{{ $user->name }}</strong>,
        </p>

        <p style="font-size: 16px; color: #334155; margin-bottom: 16px;">
            Thanks for signing up! Please verify your email address by clicking the button below to activate your account and start tracking insights.
        </p>

        <p style="text-align: center; margin: 24px 0;">
            <a href="{{ $url }}" style="background-color: #2563eb; color: white; text-decoration: none; padding: 12px 24px; font-weight: 600; border-radius: 6px; display: inline-block;">
                Verify Email
            </a>
        </p>

        <p style="font-size: 14px; color: #64748b; margin-bottom: 16px;">
            If you didn’t request this, you can safely ignore this email.
        </p>

        <p style="font-size: 14px; color: #475569;">
            — The CN_Nest Analytics Team
        </p>
    </div>

    <footer style="text-align: center; margin-top: 32px; font-size: 12px; color: #94a3b8;">
        © {{ date('Y') }} CN_Nest Analytics. All rights reserved.
    </footer>
</body>
</html>
