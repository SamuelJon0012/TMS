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
        <h2 style="color: #3d4852;">
            <center>TrackMy Lab Results</center>
        </h2>
        <h2 style="color: #3d4852;">Hello!</h2>
        <p>You are receiving this email becausewe received a passwordreset request for your account</p>
        <p style="margin: 35px 0;text-align: center;">
            <a href="{{ route("password.create", $binary) }}" style="padding: 15px 30px;background-color: #2d3748;color: #FFF;text-decoration: none;">Create Password</a>
        </p>
        <p>This password create link will expire in 60 minutes</p>
        <p>If you did not request a password create, no further action is required</p>
        <p style="margin-bottom: 5px;">Reguards,</p>
        <p style="margin: 0;">TrackMy Lab Results</p>
    </div>
        {{--<div style="max-width: 500px; margin: 0 auto;">
            <h3>Hello</h3>
            <p>Text you</p>
            <p>
                <a href="{{ route("password.create", $binary) }}">Create Password</a>
            </p>
            <p>Text if</p>
            <p>Regards</p>
            <p>{{ env("APP_NAME") }}</p>
        </div>--}}
</body>
</html>