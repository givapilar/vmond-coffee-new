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
        <div class="">
            <div class="max-w-sm h-auto bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ 'http://management-vmond.test/assets/images/meeting-room/'.$meeting_room->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">

                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $meeting_room->nama }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" id="note">
                                    {{ $meeting_room->description }}
                                </p>
                                <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                    {{ number_format($meeting_room->harga,2) }}
                                </p>

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

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 sm:gap-1 mt-3">
                <div class="max-w-full h-auto bg-white border border-gray-200 rounded-[30px] shadow px-3 sm:px-2 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-3 space-x-4">
                        <p class="text-lg font-semibold text-center border-b-2 border-gray-700 dark:text-white">Pilih Jadwal</p>
                    </div>
                    <div class="grid grid-cols-5 gap-2 justify-items-center mb-5">
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                00:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                01:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                02:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                03:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                04:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                05:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                06:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                07:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                08:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                09:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                10:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                11:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                12:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                13:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                14:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                15:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                15:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                16:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                17:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                18:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                19:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                20:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                21:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                22:00
                            </button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-white hover:bg-slate-900 text-blue-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 font-bold py-2 px-2 text-sm rounded-[12px] sm:px-2">
                                23:00
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-sm max-h-[17rem] bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700 sm:mt-2">
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
                            {{ number_format($meeting_room->harga,2) }}
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
                            Rp. {{ number_format($meeting_room->harga *11/100,2 )  }}
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
                            Rp. {{ number_format($meeting_room->harga *11/100 + $meeting_room->harga  + $biaya_layanan,2 ) }}
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
