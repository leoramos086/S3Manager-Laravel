<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> --}}
    <title>@yield('title')</title>
    <script>
        window.Laravel = @json(['csrfToken' => csrf_token(), 'baseUrl' => url('/')])
    </script>
</head>

<body>
    <div id="app">
        {{-- @include('components.navbar') --}}
        @yield('content')
    </div>

    @section('scripts')
        <script src="{{ mix('js/app.js') }}"></script>
    @show
</body>

</html>
