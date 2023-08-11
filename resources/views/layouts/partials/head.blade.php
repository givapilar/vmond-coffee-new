<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>VMOND Coffee</title>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="shortcut icon" href="{{ asset('assetku/dataku/img/logo/vmond-logo-head.png') }}" />
<link rel="apple-touch-icon" href="{{ asset('assetku/dataku/img/logo/vmond-logo-head.png') }}">
<link rel="stylesheet" href="{{ asset('assetku/dataku/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assetku/dataku/lib/slick-1.8.1/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assetku/dataku/lib/slick-1.8.1/slick/slick-theme.css') }}">
<!-- Add the slick-theme.css if you want default styling -->
{{--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>--}}
<!-- Add the slick-theme.css if you want default styling -->
{{--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">

@stack('style-top')
@stack('style-bot')

<style>
    .slick-next{
        right:10px !important;
    }
    .slick-prev{
        left:10px !important;
        z-index:20;
    }
</style>

