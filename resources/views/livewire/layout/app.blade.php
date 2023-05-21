@extends('adminlte::page')

@section('title', 'SisDocs')

@section('content')
    {{ $slot }}
@stop

@section('css')
    <!-- FoontAwesome -->
    <script src="https://kit.fontawesome.com/82da62e48d.js" crossorigin="anonymous"></script>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CK EDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    @livewireStyles
@stop

@section('js')
    <!-- Jquery Javascript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Boostrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @livewireScripts
@stop
