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
    <div style="max-width: 500px; margin: 0 auto;">
        <h3>Hello</h3>
        <p>Text you</p>
        <p>
            <a href="{{ route("password.create", $binary) }}">Create Password</a>
        </p>
        <p>Text if</p>
        <p>Regards</p>
        <p>{{ env("APP_NAME") }}</p>
    </div>
</body>
</html>
