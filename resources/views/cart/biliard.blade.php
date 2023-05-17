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
@if (session('message'))
    <div>{{ session('message') }}</div>
@endif
<section class="p-3">
    <div class="grid grid-cols-2 sm:grid-cols-1 gap-4 sm:gap-1">
        <div class="max-w-sm h-80 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            {{-- {{ dd($meeting_room->sum('harga') ) }} --}}
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                {{-- @php
                    $cart_array = cartArray();
                @endphp --}}
                {{-- {{ dd($data_carts) }} --}}
                {{-- {{ dd($item) }} --}}
                    @php
                        // $images = $item['attributes'][0];
                        // $images = explode('|',$images);
                        // $images = $images[0];
                    @endphp
                <li class="py-3 sm:py-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            {{-- <img class="w-12 h-12 rounded-full" src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80" alt="Neil image"> --}}
                            {{-- <img src="{{ asset('assetku/img'.$images) }}" alt=""> --}}
                            {{-- {{ dd($meeting_room->image) }} --}}
                            <img src="{{ 'http://management-vmond.test/assets/images/meeting-room/'.$meeting_room->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">
                            
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{-- Nasi Goreng Modern --}}
                                {{ $meeting_room->nama }}
                                {{-- {{ $item['quantity'] }} --}}
                            </p>
                            <p class="text-xs text-gray-500 truncate dark:text-gray-400" id="note">
                                {{-- Note: Pedas, No Acar Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi minus sunt provident optio, eius hic in modi voluptates est pariatur odio nam laborum fugiat reiciendis ex, ipsam natus quidem magni! --}}
                                {{-- {{ $item['attributes']['description'] }} --}}
                                {{ $meeting_room->description }}
                            </p>
                            <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                {{-- Rp. 45.000,00 --}}
                                {{-- {{ $item['price'] }} --}}
                                {{ $meeting_room->harga }}
                            </p>

                            
                            {{-- <div class="rounded-full h-7 w-32 border border-gray-500 mt-2">
                                <div class="grid h-full w-full grid-cols-3 mx-auto">
                                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group" id="remove1">
                                        <ion-icon name="remove" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                        <span class="sr-only">Remove</span>
                                    </button>

                                    <div>
                                        <input type="number" value="{{ $item->quantity }}" name="count-items" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter1" placeholder="0" required="">
                                    </div>

                                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group" id="add1">
                                        <ion-icon name="add" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                        <span class="sr-only">Add</span>
                                    </button>
                                </div>
                            </div> --}}
                            <div class="">
                                
                                <div class="col-span-4 my-4">
                                    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari</label>
                                    <input type="datetime-local" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                </div>
                                
                                <div class="col-span-4 my-4">
                                    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai</label>
                                    <input type="datetime-local" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                </div>
                            </div>


                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            {{-- <button class="flex justify-center items-center w-10 h-10 rounded-full p-2 bg-red-500 hover:bg-red-600 focus:ring-red-900 focus:ring-4"  data-modal-toggle="deleteModal">
                                <ion-icon name="trash" class=""></ion-icon>
                            </button> --}}

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
                                            {{-- <a href="{{ route('delete-cart', $item->id)}}" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Yes, I'm sure
                                            </a> --}}
                                            {{-- <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Yes, I'm sure
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="max-w-sm max-h-[17rem] bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700 sm:mt-3">
            <div class="p-3 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Order Summary</p>
            </div>
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 px-3">
                <li class="py-3 sm:py-3">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                Subtotal
                            </p>
                        </div>
                        <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                            {{-- {{ dd(number_format($meeting_room->sum('harga'),2)) }} --}}
                            {{ number_format($meeting_room->sum('harga'),2) }}
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
                             {{-- Harga Total * (11/100) --}}
                            Rp. {{ number_format($meeting_room->sum('harga')*11/100,2 )  }}
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
                                $biaya_layanan = 1000;

                            ?>
                           Rp. {{ number_format($biaya_layanan,2) }}
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
                            Rp. {{ number_format($meeting_room->sum('harga')*11/100 + $meeting_room->sum('harga') + $biaya_layanan,2 ) }}
                        </div>
                    </div>
                </li>
            </ul>

            <div class="mt-2">
                <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" onclick="location.href='{{ route('checkout') }}';">Checkout</button>
            </div>
        </div>
    </div>
</section>


<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script>
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
        responsive: [
            {
            breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 800,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
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
@endpush
