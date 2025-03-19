<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @inertiaHead
  </head>
  <body class="font-poppins">
    @inertia
  </body>
</html>