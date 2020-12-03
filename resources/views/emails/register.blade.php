<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>
        Вы успешно зарегистрировались на сайте <a href="http://euroway2go.com" target="_blank">{{ config('app.name') }}</a>
    </h3>
    <ul>
        <li>Ваш код подтверждения: {{ $code }}</li>
    </ul>
</body>
</html>