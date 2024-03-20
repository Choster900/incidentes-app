@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="image-container">
                <img src="/img/default-prof.png" alt="Logo" class="logo">
            </div>
            <h2>Inicio de sesión</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input placeholder="Correo Electrónico" value="{{ old('email') }}" type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" required />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group">
                    <input placeholder="Contraseña" type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </form>
        </div>
    </div>
@endsection

<style>
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
