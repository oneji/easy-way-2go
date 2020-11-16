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
        Для Вас создан пользователь на сайте <a href="http://euroway2go.com" target="_blank">{{ config('app.name') }}</a>
    </h3>
    <ul>
        <li>Email: {{ $email }}</li>
        <li>Пароль: {{ $password }}</li>
    </ul>
</body>
</html>