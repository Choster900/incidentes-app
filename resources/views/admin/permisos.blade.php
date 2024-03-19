@extends('adminlte::page')

@section('title', 'Permisos | Administracion')

@section('content_header')
    <h4>Administracion de Permisos</h4>
@stop

@section('content')
    <div id="app">
        <permiso-component></permiso-component>
    </div>
@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    @vite('resources/css/app.css')
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
    @vite('resources/js/app.js')

@stop