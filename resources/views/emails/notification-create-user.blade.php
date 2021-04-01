<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="max-width: 500px;margin: 0 auto;font-family: sans-serif;">
        <h2 style="color: #3d4852;">Hello {{ $name }},</h2>
        <p>An account has been created on your behalf in TrackMy Lab Results. In order to finish your account creation, click the link below to set your password.</p>
        <p style="margin: 35px 0;text-align: center;">
            <a href="{{ route("password.create", $binary) }}" style="padding: 15px 30px;background-color: #2d3748;color: #FFF;text-decoration: none;">Create Password</a>
        </p>
        <p>This link to create your password will expire in 60 minutes.</p>
        <p style="margin-bottom: 5px;">Reguards,</p>
        <p style="margin: 0;">TrackMy Lab Results</p>
    </div>
</body>
</html>
