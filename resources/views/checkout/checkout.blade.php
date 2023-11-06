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
    <script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <title>Document</title>
</head>
<body>
    <h1>Detail</h1>
    <table>
        <tr>
            <td class="text-white">Nama</td>
            <td class="text-white">{{ $order->name }}</td>
        </tr>
        {{-- <tr>
            <td class="text-white">No Hp</td>
            <td class="text-white">{{ $order->phone }}</td>
        </tr> --}}
        <tr>
            <td class="text-white">Qty</td>
            <td class="text-white">{{ $order->qty }}</td>
        </tr>
        <tr>
            <td class="text-white">Total Harga </td>
            <td class="text-white">{{ $order->total_price }}</td>
        </tr>
    </table>
    <button id="pay-button" onclick="payButton()" class="rounded-full bg-amber-300">Pay!</button>

    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
    //   var payButton = document.getElementById('pay-button');
    //   payButton.addEventListener('click', function () {
    //     // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    //     window.snap.pay('{{ $snapToken }}', {
    //       onSuccess: function(result){
    //         /* You may add your own implementation here */
    //         // alert("payment success!"); 
    //         window.location.href = '/invoice/{{ $order->id }}'
    //         console.log(result);
    //       },
    //       onPending: function(result){
    //         /* You may add your own implementation here */
    //         alert("wating your payment!"); console.log(result);
    //       },
    //       onError: function(result){
    //         /* You may add your own implementation here */
    //         alert("payment failed!"); console.log(result);
    //       },
    //       onClose: function(){
    //         /* You may add your own implementation here */
    //         alert('you closed the popup without finishing the payment');
    //       }
    //     })
    //   });
    function payButton(data) {
        $.ajax({
            url: "api/data/success-order",
            method: "POST", // First change type to method here    
            data: data,
            success: function(callback) {
                console.log('Callback', callback);
            },
            error: function(error) {
                alert("error" + error);
            }
        });    
    }
    </script>
</body>
</html>


@endsection