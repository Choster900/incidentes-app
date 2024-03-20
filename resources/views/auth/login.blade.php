<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <style>
        body {
            background-image: url('/img/login1.avif');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            /* Centramos horizontalmente */
            align-items: center;
            /* Centramos verticalmente */
        }
    </style>
</head>

<body>
    <div id="app">
        <login-component></login-component>
    </div>
</body>

</html>
