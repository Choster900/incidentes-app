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
            /* Asegúrate de que no haya ningún margen en el cuerpo */
            padding: 0;
            /* Asegúrate de que no haya ningún relleno en el cuerpo */
            height: 100vh;
            /* Establece la altura del cuerpo al 100% del viewport height */
        }

        .container {
            /* Añade estilos específicos para el contenedor si es necesario */
            /* Por ejemplo, para centrar el contenido */
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            /* Fondo semi-transparente para que el texto sea legible */
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 80px 30px 80px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bffe0;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="image-container">
                <img src="/img/default-prof.png" alt="Logo" class="logo">
            </div>
            <h2>Inicio de sesión</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input placeholder="Correo Electrónico" type="email" id="correo"
                        name="correo" class="form-control" required />
                </div>
                <div class="form-group">
                    <input placeholder="Contraseña" type="password" id="clave"
                        name="clave" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </form>
        </div>
    </div>
</body>

</html>
