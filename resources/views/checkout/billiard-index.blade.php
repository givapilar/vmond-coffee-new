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
    <div class="text-left max-w-sm bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 mt-2">
            @if ($order_last->tipe_pemesanan == 'Edisi' && Auth::user()->is_worker == true)

            <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
                <div class="relative p-4 w-full max-w-md h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah anda yakin ingin menyelesaikan pesanan?</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                No, cancel
                            </button>
                            <form action="{{ route('checkout-waiters', $token[0]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Yes, I'm sure
                                </button>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Subtotal
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        {{-- {{ dd(number_format($biliards->sum('harga'),2)) }} --}}
                        Rp. {{ number_format($harga ?? 0,2 )  }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Layanan ({{ $other_setting->layanan }}%)
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                       Rp. {{ number_format($layanan ?? 0,2) }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            PB01 ({{ $other_setting->pb01 }}%)
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                         {{-- Harga Total * (11/100) --}}
                        Rp. {{ number_format($pb01 ?? 0, 0)  }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Order Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                        
                        Rp. {{ number_format($total_harga ?? 0 ,0 ) }}
                    </div>
                </div>
            </li>
            <div class="mt-2">
                <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" data-modal-toggle="deleteModal">Order Now</button>
            </div>
            @else
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Subtotal
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        {{-- {{ dd(number_format($biliards->sum('harga'),2)) }} --}}
                        Rp. {{ number_format($harga ?? 0,2 )  }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Layanan ({{ $other_setting->layanan }}%)
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                       Rp. {{ number_format($layanan ?? 0,2) }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            PB01 ({{ $other_setting->pb01 }}%)
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                         {{-- Harga Total * (11/100) --}}
                        Rp. {{ number_format($pb01 ?? 0, 0)  }}
                    </div>
                </div>
            </li>
            <li class="py-3 px-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Order Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                        
                        Rp. {{ number_format($total_harga ?? 0 ,0 ) }}
                    </div>
                </div>
            </li>
            <div class="mt-2">
                <button id="pay-button" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button>
            </div>
            @endif
        </ul>
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
