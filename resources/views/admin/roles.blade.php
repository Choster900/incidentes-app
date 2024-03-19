@extends('adminlte::page')

@section('title', 'Roles | Administracion')

@section('content_header')
    <h4>Administracion de Roles</h4>
@stop

@section('content')
    <div id="app">
        <rol-component></rol-component>
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