<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title inertia>{{ config('app.name', 'Fifty Fifty') }}</title>
        <link rel="icon" href ="/images/icons/logo/logo-new.svg"  type="image/x-icon">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <script src="https://js.stripe.com/v3/"></script>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <script src="https://cdn.lr-ingest.com/LogRocket.min.js" crossorigin="anonymous"></script>
        <script>window.LogRocket && window.LogRocket.init('cpy20m/fiftyfifty');</script>

{{--        @if(env('APP_ENV') === 'production')--}}
{{--            <script>--}}
{{--                @if(auth()->user())--}}
{{--                    LogRocket.identify("{{auth()->user()->id}}", {--}}
{{--                        name: "{{auth()->user()->first_name}} {{auth()->user()->last_name}}",--}}
{{--                        email: "{{auth()->user()->email}}",--}}
{{--                    });--}}
{{--                @else--}}
{{--                    LogRocket.identify("Guest", {--}}
{{--                        name: "Guest Name",--}}
{{--                        email: "Guest Email",--}}
{{--                    });--}}
{{--                @endif--}}
{{--            </script>--}}
{{--        @endif--}}


    </head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZXL6WMVFXE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-ZXL6WMVFXE');
    </script>

    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
