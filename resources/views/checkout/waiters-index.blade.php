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
<section class="p-3" style="text-align: -webkit-center;">
    <div class="max-w-sm text-left h-48 bg-white border border-gray-200 rounded-[30px] shadow px-3 dark:bg-gray-800 dark:border-gray-700">
        
        <ul class="max-w-md h-full divide-y divide-gray-200 dark:divide-gray-700 overflow-y-auto">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @foreach ($data_carts as $item)
            <li class="py-3 sm:py-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-12 h-12 rounded-full" src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/'.$item->model->image ?? ''}}" alt="{{ $item->model->nama }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $item->model->nama }} Waiters
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400" id="note">
                            Note: 
                        </p>
                        @if ($item->conditions == 'Restaurant')
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            {{-- Rp. {{ $item->model->harga }} --}}
                            {{-- Rp. {{ number_format(array_sum($item->attributes['harga_add'] ?? []) + $item->model->harga ?? 0,0) }} --}}
                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->model->harga_diskon ?? 0), 0) }}

                        </p>
                        @else
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_paket'] ?? [])) + ($item->model->harga_diskon ?? 0), 0) }}

                        </p>
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

<section class="p-3" style="text-align: -webkit-center;">
    <div class="text-left max-w-sm bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 px-3 mt-2">
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Sub Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        Rp. {{ number_format(\Cart::getTotal() ?? '0',0 )  }}
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Service
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        <?php
                            $biaya_layanan = number_format((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100,0 );
                        ?>
                    {{-- {{ $order_settings[0]->layanan }} --}}
                    Rp. {{  $biaya_layanan }}
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            PB01 10%
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        <?php
                            $biaya_pb01 = number_format(((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0);
                        ?>

                        {{-- {{dd($order_settings[0]->pb01)}} --}}
                        Rp. {{ $biaya_pb01 }} 
                    </div>
                </div>
            </li>
            
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Order Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                        @if (\Cart::getTotal())
                        {{-- Rp. {{ number_format(\Cart::getTotal() *$order_settings[0]->pb01/100 + \Cart::getTotal() + $order_settings[0]->layanan ,0 ) }} --}}
                        {{-- Rp. {{ number_format(\Cart::getTotal()  ?? '0',0 ) }} --}}
                        Rp. {{ number_format((\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0)}}
                        @else
                        Rp. 0
                        @endif
                    </div>
                </div>
            </li>
        </ul>

        <div class="mt-2">
            <button id="pay-button" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button>
        </div>
    </div>
    
</section>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    //  var username = {{ \Cart::session(Auth::user()->id)->getContent() }};
        // console.log(username);
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });

    $('#note').click( function(){
        if (!$("#note").hasClass("truncate")) {
            $('#note').addClass('truncate')
        }else{
            $('#note').removeClass('truncate')
        }
    })

    let getVar = parseInt($('#add1').val());

    $('#add1').click( function(){
        if(!getVar || getVar == NaN){
            getVar = 1;
            $('.counter1').val(getVar);
        }else{
            getVar = getVar + 1;
            $('.counter1').val(getVar);
        }
    })

    $('#remove1').click( function(){
        if(!getVar || getVar == NaN){
            getVar = 0;
            $('.counter1').val(getVar);
        }else{
            getVar = getVar - 1;
            $('.counter1').val(getVar);
        }
    })
 </script>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
      window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
          /* You may add your own implementation here */
          // alert("payment success!"); 
            var data = {!! json_encode(\Cart::session(Auth::user()->id)->getContent()) !!};

            let newData = {
                'order_id' : result.order_id,
                'data_menu' : data,
            };
            $.ajax({
                type: 'POST',
                url: "{{ route('success-order') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": newData
                },
                success: function (data) {
                    window.location.href = '/home';
                    console.log('Callback', data);
                },
                error: function (data) {
                    alert("error" + JSON.stringify(error));
                    // console.log(JSON.stringify(error));
                }
            });
          console.log(result);
        },
        onPending: function(result){
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
          window.location.href = '/cart'
        },
        onError: function(result){
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function(){
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      })
    });
  </script>
@endpush
