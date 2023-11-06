@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .scroll-active{
        height: 15rem;

    }
</style>
@endpush

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Invoice</h1>
    <table>
        <tr>
            <td class="text-white">Nama</td>
            <td class="text-white">{{ $order->name }}</td>
        </tr>
        <tr>
            <td class="text-white">No Hp</td>
            <td class="text-white">{{ $order->phone }}</td>
        </tr>
        <tr>
            <td class="text-white">Qty</td>
            <td class="text-white">{{ $order->qty }}</td>
        </tr>
        <tr>
            <td class="text-white">Status </td>
            <td class="text-white">{{ $order->status }}</td>
        </tr>
    </table>
    
</body>
</html>
@endsection