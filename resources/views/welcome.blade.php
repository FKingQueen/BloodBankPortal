<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}"/> -->
        <title>NOPH</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <script>
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>
    </head>
    <body class="antialiased">
    
        @if (!Auth::check())
            <script>
                window.Laravel = {!!json_encode([
                    'isLoggedin' => false,
                    'csrfToken' => csrf_token() ,
                ])!!}
            </script>
        @elseif(Auth::check())
            <script>
                window.Laravel = {!!json_encode([
                    'isLoggedin' => true,
                    'userType' => Auth::user()->userType,
                    'user' => Auth::user(),
                    'currentRoom' => null,
                    'csrfToken' =>  csrf_token() ,
                ])!!}
            </script>
        @endif
        <div id="app">

        </div>
        <script src="{{mix('/js/app.js')}}"></script>
        
    </body>
</html>
