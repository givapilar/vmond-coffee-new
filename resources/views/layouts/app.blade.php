<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body class="dark:bg-gray-900 xl:max-w-screen-md">

@include('layouts.partials.header')

<hr class="mx-auto" style="width: 95%">

@yield('content')

@include('layouts.partials.footer')

</body>

@include('layouts.partials.foot')
</html>
