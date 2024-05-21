<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        @if (env('GOOGLE_REBOT_BAN', false))
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex">
        @endif

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        {{-- <title>五術研究社</title> --}}

        <link rel="icon" href="../favicon.ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-main-white h-screen">
        @inertia

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <noscript>Your browser does not support JavaScript. If the webpage function is not working properly, please open the browser JavaScript status.</noscript>
    </body>
</html>
