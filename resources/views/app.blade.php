<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Laravel</title>


        @vite('resources/js/app.js')
        @inertiaHead
        @routes
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        @inertia
    </body>
</html>
