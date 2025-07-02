<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px;">

  <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <h1 style="font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 20px;">
      Reset Your Password
    </h1>

    <p style="font-size: 16px; color: #374151; margin-bottom: 30px;">
      Hello {{ $user->name }},
    </p>

    <p style="font-size: 16px; color: #374151; margin-bottom: 30px;">
      You recently requested to reset your password. Click the button below to reset it.
    </p>

    <a href="{{ $url }}" 
       style="display: inline-block; background-color: #ef4444; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">
      Reset Password
    </a>

    <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
      If you did not request a password reset, please ignore this email.
    </p>

  </div>
</body>
</html>
