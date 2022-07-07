@php
    use Illuminate\Support\Facades\Config;

    $socialMessage = Config::get('_socials.message')
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/members.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>{{ $title }}</title>
</head>
<body>

<div id="app">
    <router-view :social-message="'{{$socialMessage}}'"></router-view>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
<script>


</script>
