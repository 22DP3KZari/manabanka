<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3B82F6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Reset Your Password</h2>
    
    <p>Hello,</p>
    
    <p>We received a request to reset your password for your manaBanka account. Click the button below to reset your password:</p>
    
    <a href="{{ $actionUrl }}" class="button">Reset Password</a>
    
    <p>This password reset link will expire in 60 minutes.</p>
    
    <p>If you did not request a password reset, no further action is required.</p>
    
    <div class="footer">
        <p>If you're having trouble clicking the button, copy and paste this URL into your web browser:</p>
        <p>{{ $actionUrl }}</p>
    </div>
</body>
</html> 