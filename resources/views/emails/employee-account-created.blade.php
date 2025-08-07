<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>

<body>
    <h2>Hi {{ $name }},</h2>

    <p>Your employee account has been created successfully.</p>

    <p><strong>Login Details:</strong></p>
    <ul>
        <li>Email: {{ $email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <p>We recommend changing your password after your first login.</p>

    <p>Thank you,<br>The Admin Team</p>
</body>

</html>