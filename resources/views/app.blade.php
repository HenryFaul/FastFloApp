<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="The Perfect Beer in Seconds">
        <meta name="keywords" content="FastFlo, Beer, CUPL">

        <!--  Essential META Tags -->
        <meta property="og:title" content="FastFlo">
        <meta property="og:image" content="'https://pay.cupl.co.za/logos/flo.png'">
        <meta property="og:url" content="https://pay.cupl.co.za/">

        <!--  Non-Essential, But Recommended -->
        <meta property="og:description" content="The Perfect Beer in Seconds">
        <meta property="og:site_name" content="The Perfect Beer in Seconds">

        <meta name="author" content="FastFlo">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
