@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Welcome {{ __($user_name) }}</h1>
@stop

@section('content')
    <p>Welcome to the admin panel.</p>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <!--script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script-->
@stop