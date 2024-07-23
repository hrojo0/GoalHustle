<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/icono.ico') }}">

        <!--title>{{ config('app.name', 'Laravel') }}</title-->
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700%7CPoppins:400,300,500,600,700" rel="stylesheet" type="text/css">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


             <!-- Scripts -->
             @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Estilos css generales -->
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('css/colors.css') }}" rel="stylesheet">




        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        

        <!-- estilos bladewindui -->
        <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

        @if (Route::has('dashboard'))
            <!--solo se cargará el codigo cuando el link contenga 'dashboard' en alguna parte -->
        @endif

        @yield('styles')

        
        
        
   
        
	    <link href='https://fonts.googleapis.com/css?family=Merriweather:300,400,700%7CPoppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper"  style="overflow: hidden">

            @include('layouts.navigation') <!-- incluir header -->



            <!-- Page Heading -->
            @if (isset($header))
            <!--header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header-->
            @endif
            <main id="main" role="main">
                {{ $slot }}
                
            </main>
            <span id="back-top" class="fa fa-angle-up"></span>

        </div>
        
        
          @include('layouts.footer')
        

        @yield('scripts')

        <!-- Scripts -->
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/jquery.main.js') }}"></script>
    </body>
</html>
