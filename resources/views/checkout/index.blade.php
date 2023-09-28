@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .scroll-active{
        height: 15rem;

    }
    .jconfirm-cell{
        display: flex !important;
        justify-content: center !important; /* Menengahkan secara horizontal */
        align-items: center !important;
    }
    .jconfirm-box{
        background-color: #1b1818 !important;
        border-radius: 20px !important;
    }
    .jconfirm-title-c{
        display: none !important;
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
                        <img src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/'.$item->attributes['restaurant']['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">

                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $item->attributes['restaurant']['nama'] }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400" id="note">
                            Qty: {{ $item['quantity'] }}
                        </p>
                        @if ($item->conditions == 'Restaurant')
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            {{-- Rp. {{ $item->model->harga }} --}}
                            {{-- Rp. {{ number_format(array_sum($item->attributes['harga_add'] ?? []) + $item->model->harga ?? 0,0) }} --}}
                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->attributes['restaurant']['harga_diskon'] ?? 0), 0) }}

                        </p>
                        @else
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_paket'] ?? [])) + ($item->attributes['restaurant']['harga_diskon'] ?? 0), 0) }}

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
            {{-- Super Platinum --}}
            @if (Auth::user()->membership->level == 'Super Platinum')
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Sub Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        Rp. 1
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
                    {{-- Rp. {{  $biaya_layanan }} --}}
                    Rp. 1
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

                        {{-- Rp. {{ $biaya_pb01 }}  --}}
                        Rp. 1 
                    </div>
                </div>
            </li>
            
            @if ($order_last->packing == '5000')
                
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Packing 
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        <?php
                            $packing = 5000;
                        ?>

                        Rp. 1 
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
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary-packing">
                        <?php
                            $packing = 5000;
                            $totalWithoutPacking = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100;
                            $totalWithPacking = $totalWithoutPacking + $packing;
                        ?>
                            Rp. 1
                    </div>
                </div>
            </li>
            @else
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Order Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary">
                        Rp. 1
                    </div>
                </div>
            </li>
            @endif

            {{-- user Normal --}}

            {{-------------------------------------------- Bu fitri ------------------------------------------------------}}
            @elseif(Auth::user()->telephone == '081210469621')
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
            
            {{-- -----------------------------Normal--------------------------------------------- --}}
            @else

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
                    {{-- Rp. {{  $biaya_layanan }} --}}
                    Rp. {{  $order_last->service }}
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

                        {{-- Rp. {{ $biaya_pb01 }}  --}}
                        Rp. {{ $order_last->pb01 ?? '-' }} 
                    </div>
                </div>
            </li>
            
            @if ($order_last->packing == '5000')
                
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Packing 
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        <?php
                            $packing = 5000;
                        ?>

                        Rp. {{ $packing }} 
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
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary-packing">
                        <?php
                            $packing = 5000;
                            $totalWithoutPacking = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100;
                            $totalWithPacking = $totalWithoutPacking + $packing;
                        ?>
                        @if (\Cart::getTotal())
                            {{-- Rp. {{ number_format($totalWithPacking, 0) }} --}}
                            Rp. {{ number_format($order_last->total_price, 0) }}
                        @else
                        Rp. 0
                        @endif
                    </div>
                </div>
            </li>
            @else
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Order Total
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary">
                        @if (\Cart::getTotal())
                        {{-- Rp. {{ number_format((\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0)}} --}}
                        Rp. {{ number_format($order_last->total_price,0)}}
                        @else
                        Rp. 0
                        @endif
                    </div>
                </div>
            </li>

            {{-- <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                            Voucher Diskon
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary">
                        {{ number_format($order_last->voucher_diskon,0) }}
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
                    <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary">
                        {{ number_format($order_last->total_price,0) }}
                    </div>
                </div>
            </li> --}}

            @endif

            @endif
            

        </ul>

        {{-- @foreach ($order_last as $item) --}}
            
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
            <div class="mt-2">
                <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" data-modal-toggle="deleteModal">Order Now</button>
            </div>
       
        @elseif($order_last->tipe_pemesanan == 'BJB-Testing')
            <div class="mt-2">
                <button id="btnQR" onclick="createQris('{{ $order_last->total_price }}', '{{ $order_last->id }}')" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button>
            </div>
        @else
        <div class="mt-2">
            <button id="pay-button" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button>
        </div>
        {{-- <div class="mt-2">
            <button id="btnQR" onclick="createQris('{{ $order_last->total_price }}', '{{ $order_last->id }}')" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button>
        </div> --}}
        @endif 

        {{-- <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Order Now</button> --}}
    </div>
    
</section>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('assetku/dataku/js/socket.io.js') }}"></script>

<script>
    let socket = window.socketio;
    socket = io.connect('https://socket-vmondcoffee.controlindo.com:443'); // koneksi ke nodejsnya
    socket.on('notif-berhasil', function(data) {
        checkData(data, function(result) {
            let order_id = {!! $order_last->id !!};

            if (order_id == result) {
                // console.log('Masuk');
                // Handle the result here
                $.confirm({
                    title: "Pembayaran Berhasil!",
                    content: "Pembayaran Berhasil, Terimakasih!",
                    theme: "modern",
                    icon: "fa fa-check-circle", // Ikon sukses (gunakan kelas ikon Font Awesome)
                    buttons: {
                        close: {
                            text: 'OK',
                            btnClass: 'btn-green',
                            action: function () {
                                window.location.href = "https://vmondcoffee.controlindo.com/home";
                            }
                        }
                    },
                });
            }
        }, function(error) {
            var confirmation = confirm("Pembayaran Gagal!");
    
            // Memeriksa apakah pengguna mengklik OK
            if (confirmation) {
                // Redirect ke halaman lain jika pengguna mengklik OK
                window.location.href = "https://vmondcoffee.controlindo.com/home";
            }
            // Handle the error here
        });
    });
    
    function checkData(i, successCallback, errorCallback) {
        let datas = i;

        // Prepare the data to send in the request
        const requestData = {
            "_token": "{{ csrf_token() }}",
            datas,
        };

        $.ajax({
            type: 'POST',
            url: "{{ route('check-data') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: requestData,
            success: function(res) {
                // console.log(res);
                if (typeof successCallback === 'function') {
                    successCallback(res);
                }
            },
            error: function(data) {
                // console.log(data);
                // console.log('Failed!');
                if (typeof errorCallback === 'function') {
                    errorCallback(data);
                }
            }
        });
    }
    
    // Membuat variabel flag untuk status
    let isProcessing = false;
    
    function createQris(dtamount, dtorderid) {
        console.log(isProcessing);
        // Memeriksa apakah proses sedang berlangsung
        if (isProcessing) {
            // Jika proses sedang berlangsung, mencegah fungsi dijalankan
            return;
        }
    
        // Mengubah status menjadi sedang proses
        isProcessing = true;
    
        // let amount = dtamount;
        let amount = 1;
        $('#btnQR').prop('disabled', true);
        $('#btnQR').addClass('disabled');
    
        $.ajax({
            type: 'POST',
            url: "{{ route('create-qris-merchant') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                amount,
            },
            async: false,
            success: function(res) {
                // console.log(res);
                // console.log(res.data.stringQR);
                // Menutup dialog jQuery Confirm setelah sukses
                generateQris(res.data.stringQR, dtamount);
                updateInvoice(dtorderid, res.data.invoiceID)
                // window.location.href = "{{ route('homepage') }}";
                $('#btnQR').removeClass('disabled');
                
                $("#btnQR").prop("disabled", false);
    
                // Mengubah status menjadi selesai
            },
            error: function(data) {
                // console.log(data);
                $('#btnQR').removeClass('disabled');
                $("#btnQR").prop("disabled", false);
                $.alert(data.responseJSON.message);
    
                // Mengubah status menjadi selesai
                isProcessing = false;
            }
        });
    }
    
    
    function generateQris(strQR, dtamount) {
        // Create a QRious instance
        var qr = new QRious({
            value: strQR,
            size: 200, // Sesuaikan ukuran sesuai kebutuhan
        });
    
        // Convert the QR code to a data URL
        var qrDataUrl = qr.toDataURL();
    
        $.confirm({
            title: 'Generate QR Code',
            content: '<img src="' + qrDataUrl + '" width="70%" height="70%" style="display:block; margin-right:auto; margin-left:auto; margin-top:10px; border-radius:15px;">'+
            '</br>'+
            '<h3 style="color:white;text-align:center;margin-bottom:10px;">VMOND COFFEE x BJB</h3>'+
            '<h5 style="color:white;text-align:center;">Total : '+dtamount+'</h5>',
            columnClass: 'small',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                downloadQR: {
                    text: 'Download QR Code',
                    btnClass: 'btn-green',
                    action: function () {
                        // Trigger download of QR Code image
                        var a = document.createElement('a');
                        a.href = qrDataUrl;
                        a.download = 'qrcodes.png'; // Nama file yang akan diunduh
                        a.style.display = 'none';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        isProcessing = false;
                    }
                },
                close: {
                    text: 'Close',
                    action: function () {
                        // Close the dialog
                        isProcessing = false;
                    }
                }
            }
        });
    }
    
    function updateInvoice(orderID, invoiceID) {
        let order_id, data;
        console.log(orderID, invoiceID);
        order_id = orderID;
        invoice_id = invoiceID;
        $.ajax({
            type: 'POST',
            url: "{{ route('update-invoice') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                order_id,
                invoice_id,
            },
            async: false,
            success: function(res) {
                // console.log(res);
                // window.location.href = '/home';
                // console.log('Success!');
            },
            error: function(data) {
                // console.log('Failed!');
                alert('Gagal, Silahkan order ulang...')
            }
        });
    }
</script>

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
                    // console.log('Callback', data);
                },
                error: function (data) {
                    alert("error" + JSON.stringify(error));
                    // console.log(JSON.stringify(error));
                }
            });
          console.log(result);
          console.log('Payment Method:', paymentType);
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
