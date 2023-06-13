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
            @foreach ($data_carts as $item)
            <li class="py-3 sm:py-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-12 h-12 rounded-full" src="{{ 'http://management-vmond.test/assets/images/restaurant/'.$item->model->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $item->model->nama }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400" id="note">
                            Note: 
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            Rp. {{ $item->model->harga }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            Total {{ $item->quantity }}
                        </p>

                        {{-- <div class="rounded-full h-7 w-32 border border-gray-500 mt-2">
                            <div class="grid h-full w-full grid-cols-3 mx-auto">
                                <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group" id="remove1">
                                    <ion-icon name="remove" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                    <span class="sr-only">Remove</span>
                                </button>

                                <div>
                                    <input type="number" name="qty" value="{{ $item->quantity }}" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter1" placeholder="0" required="">
                                </div>

                                <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group" id="add1">
                                    <ion-icon name="add" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                    <span class="sr-only">Add</span>
                                </button>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <button class="flex justify-center items-center w-10 h-10 rounded-full p-2 bg-red-500 hover:bg-red-600 focus:ring-red-900 focus:ring-4"  data-modal-toggle="deleteModal">
                            <ion-icon name="trash" class=""></ion-icon>
                        </button>

                        <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
                            <div class="relative p-4 w-full max-w-md h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, cancel
                                        </button>
                                        <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            Yes, I'm sure
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- <section class="p-3 " style="text-align: -webkit-center;">
    <div class="text-left max-w-sm h-36 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
        <div class="p-2 space-x-4">
            <p class="text-lg font-semibold text-center dark:text-white">Pilih Category</p>
        </div>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 px-3">
            <li class="py-3 sm:py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/takeaway.png') }}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Takeway
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <input id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/dinein.png') }}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Dine In
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <input id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section> --}}

{{-- <section class="p-3">
    <div class="max-w-sm h-48 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
        <div class="p-2 space-x-4">
            <p class="text-lg font-semibold text-center dark:text-white">Metode Pembayaran</p>
        </div>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 px-3">
            <li class="py-3 sm:py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://gopay.co.id/icon.png" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Gopay
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <input id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://theme.zdassets.com/theme_assets/1379487/2cb35fe96fa1191f49c2b769b50cf8b546fff65e.png" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Ovo
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <input id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://play-lh.googleusercontent.com/oXs9tsmauo4_xFDsovB7i3ONfNWZ9FR8shrnegcYC4tHCjybZexXa0fpe9N_3kYqw-U" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Shopee Pay
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <input id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section> --}}

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
                        {{ number_format(\Cart::getTotal() ?? '0',2 )  }}
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            PPN 11%
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        Rp. {{ number_format((\Cart::getTotal() ?? '0') * 11/100,2 )  }}
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Layanan
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        <?php
                        $biaya_layanan = 5000;

                    ?>
                    Rp. {{ number_format($biaya_layanan ?? '0',2) }}
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
                        @if (\Cart::getTotal() ?? 0)
                            
                        Rp. {{ number_format(\Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan ,2 ) }}
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
                url: 'api/data/success-order',
                method: "POST", // First change type to method here   
                data: newData,
                success: function(callback) {
                    console.log('Callback', callback);
                    window.location.href = '/home'

                },
                error: function(error) {
                    alert("error" + error);
                }
            });    
          console.log(result);
        },
        onPending: function(result){
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
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
