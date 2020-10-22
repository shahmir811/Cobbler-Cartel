<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cobbler Cartel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script type="text/javascript">
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token()
        ]) !!};
        let APP_URL = {!! json_encode(url('/').'/') !!}
        </script>
    </head>
    <body>
        <div id="app">
            <app />
        </div>
        <script src="{!! asset('js/app.js') !!}" charset="utf-8"></script>
    </body>
    </html>
