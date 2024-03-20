@extends('adminlte::page')

@section('title', 'Departamentos | Administracion')

@section('content_header')
    <h4>Administra los incidentes</h4>
@stop

@section('content')
    <div id="app">
       {{--  <departamento-component></departamento-component> --}}
       <incidente-component/>
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
