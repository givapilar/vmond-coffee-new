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
        <div class="max-w-sm h-96 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            @foreach ($data_carts as $item)

            <input type="hidden" name="category" value="restaurant">
            {{-- {{ dd($item->attributes->jam) }} --}}

            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                <li class="py-3 sm:py-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/'.$item->model->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">

                        </div>
                        <div class="flex-1 min-w-0">
                            @if ($item->model->nama)
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $item->model->nama }}
                                {{-- {{ $item->model->nama_paket }} --}}
                            </p>
                            
                            @else
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $item->model->nama_paket }}
                            </p>
                            @endif

                            @if ( $item->model->stok_perhari)
                            <p>
                                <span class="block text-[10px] dark:text-yellow-300">Stock {{ $item->model->stok_perhari }}</span>
                            </p>
                            @endif
                            {{-- <p class="text-xs text-gray-500 truncate dark:text-gray-400" id="note">
                            </p> --}}
                            {{-- {{ dd($item->attributes) }} --}}
                            @if ($item->conditions == 'Restaurant')
                            <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                {{-- Rp. {{ $item->model->harga }} --}}
                                {{-- Rp. {{ number_format(array_sum($item->attributes['harga_add'] ?? []) + $item->model->harga ?? 0,0) }} --}}
                                Rp. {{ number_format(array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->model->harga ?? 0), 0) }}

                            </p>
                            @else
                            <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                Rp. {{ number_format(array_sum((array) ($item->attributes['harga_paket'] ?? [])) + ($item->model->harga ?? 0), 0) }}

                            </p>
                            @endif
                            {{-- <p class="text-xs text-gray-500  dark:text-red-500">
                                Note {{ implode(', ', $item->attributes['add_on_title']) }} {{ implode(', ', $item->attributes['harga_add']) }}  
                                {{ array_sum($item->attributes['harga_add']) }}

                            </p> --}}


                            <div class="rounded-full h-7 w-32 border border-gray-500 mt-2">
                                <div class="grid h-full w-full grid-cols-3 mx-auto">
                                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group" onclick="remove('{{ strtolower(str_replace(' ','-',$item->model->nama)) }}',  {{ $item->model->id }})">
                                        <ion-icon name="remove" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                        <span class="sr-only">Remove</span>
                                    </button>

                                    <div>
                                        <input type="number" value="{{ $item->quantity }}" name="qty" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter-{{ strtolower(str_replace(' ','-',$item->model->nama)) }}" placeholder="0" required="">
                                    </div>

                                    <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group" onclick="add('{{ strtolower(str_replace(' ','-',$item->model->nama)) }}',  {{ $item->model->id }})">
                                        <ion-icon name="add" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                        <span class="sr-only">Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
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
                                            <a href="{{ route('delete-cart', $item->id)}}" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Yes, I'm sure
                                            </a>
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
                <form action="{{ route('checkout-order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jam" value="{{ $item->attributes->jam }}" id="">

                @endforeach
                {{-- <form action="{{ route('xendit-order') }}" method="POST">
                    @csrf
                    <label for="">External Id</label>
                    <input type="text" name="external_id" id="external_id">

                    <label for="">Payer Email</label>
                    <input type="text" name="payer_email" id="payer_email">
                    
                    <label for="">Description</label>
                    <input type="text" name="description" id="description">

                    <label for="">Amount</label>
                    <input type="number" name="amount" id="amount">

                    <label for="">Customer Names</label>
                    <input type="text" name="given_names" id="given_names">

                    <label for="">mobile phone</label>
                    <input type="text" name="mobile_phone" id="mobile_phone">

                    <label for="">Item Name</label>
                    <input type="text" name="name" id="name">

                    <label for="">Price</label>
                    <input type="number" name="price" id="price">
                    
                    <div class="mt-2">
                        <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Xendit</button>
                    </div>
                </form> --}}
            </ul>
        </div>

            
        {{--<div class="text-left max-w-sm h-96 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Pilih Category</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700 px-3">
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
                        <input id="takeaway-radio" type="radio" value="Takeaway" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                        <input id="dine-in-radio" type="radio" value="dine-in" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </li>
            <li class="py-3 sm:py-2">
                <div id="select-input-wrapper">
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja</label>
                        <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option disabled selected>Pilih Meja Restaurant</option>
                            @foreach ($meja_restaurants as $key => $meja_restaurant)
                                <option value="{{ $meja_restaurant->id }}">{{ $meja_restaurant->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
            </ul>
        </div>
        @endif --}}

        {{-- {{ dd($jam) }} --}}

        @foreach ($processedCartItems as $item)
        {{-- {{ dd($processedCartItems) }} --}}
            
        @if ($item['conditions'] == 'Paket Menu')
            
        <div class="max-w-full h-64 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Schedule & Table Billiard</p>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mt-4">
                    <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>                    
                    <input type="date" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="disableHour()">
                </div>
                <div class="mt-4">
                    <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from" required name="time_from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Choose a Time From</option>
                        <option value="00:00">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div>

                {{-- <div class="mt-4">
                    <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time To</label>
                    <select id="time_to" required name="time_to" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Choose a Time To</option>
                        <option value="00:00">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div> --}}
                <div class="mt-4">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Biliard</label>
                    <select id="biliard_id" name="biliard_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Pilih Meja Biliard</option>
                        @foreach ($biliards as $key => $biliard)
                            <option value="{{ $biliard->id }}">{{ $biliard->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                
            </div>
        </div>
        @elseif($item['conditions'] == 'Paket Menu Meeting')
        <div class="max-w-full h-64 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Schedule & Table Meeting Room</p>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mt-4">
                    <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>                    
                    <input type="date" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="disableHour()">
                </div>
                <div class="mt-4">
                    <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_meeting" required name="time_from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Choose a Time From</option>
                        <option value="00:00">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Meeting</label>
                    <select id="meeting_room_id" name="meeting_room_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Pilih Meja Meeting</option>
                        @foreach ($meeting_rooms as $key => $meeting_room)
                            <option value="{{ $meeting_room->id }}">{{ $meeting_room->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                
            </div>
        </div>
        @endif
        @endforeach

    </div>

    {{-- <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 gap-4 sm:gap-1 mt-2">
        
    </div> --}}

    {{-- @foreach ($data_carts as $paket)
    @if ($paket->model->nama_paket)

        
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 gap-4 sm:gap-1 mt-2">
        <div class="max-w-full h-96 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Select Food & Drink</p>
            </div>
            <div class="grid grid-cols-1 gap-2">
                <div class="mt-9 ml-4">
                    <ul class="max-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($restaurants as $index => $restaurant)
                        <li class="pb-3 sm:pb-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $restaurant->nama }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Rp.  {{ number_format($restaurant->harga, 0) }}
                                    </p>
                                </div>
                                <div class="flex items-center mb-4">
                                    <input id="checkbox" name="restaurant_id[]" type="checkbox" value="{{ $restaurant->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onchange="toggleCheckbox(this, '{{ $paket->model->nama_paket }}' , '{{ $paket->model->minimal }}')">
                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach --}}
{{-- </form> --}}

    <div class="max-w-full mt-2 max-h-[17rem] bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700 sm:mt-3">
        <div class="p-3 space-x-4">
            <p class="text-lg font-semibold text-center dark:text-white">Order Summary</p>
        </div>
        <ul class="max-w-full divide-y divide-gray-200 dark:divide-gray-700 px-3">
            <li class="py-3 sm:py-3">
                <div class="flex items-start space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                            Subtotal
                        </p>
                    </div>
                    <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                        {{-- {{ dd(number_format($total)) }} --}}
                        {{-- Rp. {{ number_format($item->model->harga ?? '0',2 ) }} --}}
                        Rp. {{ number_format(\Cart::getTotal()  ?? '0',2 ) }}
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
                        Rp. {{ number_format((\Cart::getTotal() ?? '0') * 10/100,2 )  }}
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
                        
                        Rp. {{ number_format(\Cart::getTotal() *10/100 + \Cart::getTotal() + $biaya_layanan ,2 ) }}
                        @else
                        Rp. 0
                        @endif

                    </div>
                </div>
            </li>
        </ul>

        
            <div class="mt-2">
                <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
            </div>
        </form>
    </div>

    
</section>

{{-- @if (count($response_data) != null || count($response_data) != 0)
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU RESTAURANT</span>
        </div>
        <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div>
    </div>

    <div class="slick1 pt-2">
        @foreach ($response_data as $item)
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama ?? 'Error' }}</p>
                <span class="block text-[10px] dark:text-red-500">Rp.{{ $item->harga }}</span>

                <div class="flex gap-1 opacity-75">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type'=>'resto', 'slug'=>$item->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif --}}

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')

<script>
    function toggleCheckbox(checkbox, minimal, namaPaket) {
        console.log(minimal);
        console.log(namaPaket);
        if (checkbox.checked && namaPaket > minimal) {
            checkbox.disabled = true;
        }
    }
</script>

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


    function add(slug, $id){
        let getVar = parseInt($('.counter-'+slug).val());
        if(!getVar || getVar == NaN){
            getVar = 1;
            $('.counter-'+slug).val(getVar);
        }else{
            getVar = getVar + 1;
            $('.counter-'+slug).val(getVar);
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('cart-update') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "qty": getVar,
                "id": $id
            },
            success: function (data) {
                location.reload();
                // window.location.href(url)
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function remove(slug, $id){
        let getVar = parseInt($('.counter-'+slug).val());
        if(!getVar || getVar == NaN){
            getVar = 0;
            $('.counter-'+slug).val(getVar);
        }else{
            getVar = getVar - 1;
            $('.counter-'+slug).val(getVar);
        }

        $.ajax({
            type: 'POST',
            url: "{{ route('cart-update') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "qty": getVar,
                "id": $id
            },
            success: function (data) {
                location.reload();
                // window.location.href(url)
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }
 </script>

{{-- Untuk DIsable Jam pada tanggal tertentu --}}
<script>
    function disableHour()
    {
        var valueDate = $('#date').val();
        $.ajax({
            type: 'POST',
            url: "{{ route('check-schedule') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "date": valueDate
            },
            success: function (data) {
                console.log(data);
                $("#time_from option").attr('disabled', false); 
                $("#biliard_id option").attr('disabled', false); 
                data.times.forEach(element => {
                    let valHourFrom = element.substring(0, 5);
                    console.log(element);
                    $("#time_from option[value='"+ valHourFrom + "']").attr('disabled', true); 
                    // $("#time_to option[value='"+ valHourFrom + "']").attr('disabled', true); 
                    // $("#biliard_id option[value='" + valHourFrom + "']").attr('disabled', true); 
                });
                
                data.billiardIds.forEach(elementBiliard => {
                    let biliard = elementBiliard;
                    console.log(elementBiliard);
                    $("#biliard_id option[value='"+ elementBiliard + "']").attr('disabled', true); 
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    // function disableHour() {
    //     var valueDate = $('#date').val();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{ route('check-schedule') }}",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "date": valueDate
    //         },
    //         success: function (data) {
    //             data.times.forEach(function (element) {
    //                 let valHourFrom = element.substring(0, 5);
    //                 $("#time_from option[value='" + valHourFrom + "']").prop('disabled', true);
    //                 $("#time_to option[value='" + valHourFrom + "']").prop('disabled', true);
    //                 $("#billiard_id option[value='" + valHourFrom + "']").prop('disabled', true);
    //             });
                
    //         },
    //         error: function (data) {
    //             $.alert('Failed!');
    //             console.log(data);
    //         }
    //     });
    // }

</script>

{{-- Disable Hour Jam Meeting --}}
{{-- <script>
    function disableHourMeeting()
    {
        var valueDate = $('#date').val();
        $.ajax({
            type: 'POST',
            url: "{{ route('check-schedule') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "date": valueDate
            },
            success: function (data) {
                console.log(data);
                $("#time_from option").attr('disabled', false); 
                $("#meeting_id option").attr('disabled', false); 
                data.times.forEach(element => {
                    let valHourFrom = element.substring(0, 5);
                    console.log(element);
                    $("#time_from_meeting option[value='"+ valHourFrom + "']").attr('disabled', true); 
                    // $("#time_to option[value='"+ valHourFrom + "']").attr('disabled', true); 
                    // $("#biliard_id option[value='" + valHourFrom + "']").attr('disabled', true); 
                });
                
                data.billiardIds.forEach(elementBiliard => {
                    let biliard = elementBiliard;
                    console.log(elementBiliard);
                    $("#meeting_id option[value='"+ elementBiliard + "']").attr('disabled', true); 
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

</script> --}}
@endpush
