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
<section class="p-3">
    @if ($data_carts->count() >= 1)
        @if (Auth::user()->telephone == '089629600054')
            {{-- <form method="POST" action="{{ route('create-token-bri') }}"> --}}
            <form action="{{ route('checkout-order', md5(strtotime("now"))) }}" method="POST">
        @else
            <form action="{{ route('checkout-order', md5(strtotime("now"))) }}" method="POST">
        @endif
            {{-- <form method="POST" action="{{ route('create-token-dsp') }}"> --}}
            @csrf   
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-4 sm:gap-1">
                <div class="max-w-sm h-96 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
                    @foreach ($data_carts as $key => $item)
                    {{-- {{ dd($item) }} --}}
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:py-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/'.$item->attributes['restaurant']['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">

                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item->attributes['restaurant']['nama'] ?? '' }}
                                        </p>

                                        <p>
                                            <span class="block text-[10px] dark:text-yellow-300">Stock {{ $item->attributes['restaurant']['current_stok'] ?? '-' }}</span>
                                        </p>

                                        <p>
                                            @if(isset($item->attributes['detail_addon_id']))
                                                @foreach($item->attributes['detail_addon_id'] as $addonId)
                                                    @if(isset($addonId))
                                                        @php
                                                            $detailAddOn = App\Models\AddOnDetail::find($addonId);
                                                        @endphp
                                                        
                                                        @if($detailAddOn && isset($detailAddOn->nama))
                                                            <span class="block text-[10px] dark:text-white">
                                                                {{ $detailAddOn->nama }}
                                                            </span>
                                                        @else
                                                            <span class="block text-[10px] dark:text-yellow-300">Nama tidak ditemukan</span>
                                                        @endif
                                        
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="block text-[10px] dark:text-yellow-300">Tidak Ada Note</span>
                                            @endif
                                        </p>
                                        
                                        

                                        {{-- <p>
                                            <span class="block text-[10px] dark:text-yellow-300">Note :</span>
                                            @foreach ($item->attributes['restaurant']->addOns as $addOns)
                                                @foreach ($addOns->addOn->detailAddOn as $detailAddOns)
                                                        <span class="block text-[10px] dark:text-yellow-300">{{ $detailAddOns->nama }}</span>
                                                @endforeach
                                            @endforeach
                                        </p> --}}
                                        
                                        <p class="text-xs italic line-through text-gray-500 truncate dark:text-slate-500">
                                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->attributes['restaurant']['harga'] ?? 0), 0) }}
                                        </p>

                                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                            Rp. {{ number_format(array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->attributes['restaurant']['harga_diskon'] ?? 0), 0) }}
                                        </p>

                                        <div class="rounded-full h-7 w-32 border border-gray-500 mt-2">
                                            <div class="grid h-full w-full grid-cols-3 mx-auto">
                                                <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group" onclick="remove('{{ strtolower(str_replace(' ','-',$key)) }}',  {{ $item->attributes['restaurant']['id'] }})">
                                                    <ion-icon name="remove" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                                    <span class="sr-only">Remove</span>
                                                </button>

                                                <div>
                                                    <input type="number" value="{{ $item->quantity }}" name="qty[]" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter-{{ strtolower(str_replace(' ','-',$key)) }}" placeholder="0" required="" readonly>
                                                    <input type="hidden" value="{{ $key }}" name="idSession[]">
                                                </div>

                                                <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group" onclick="add('{{ strtolower(str_replace(' ','-',$key)) }}',  {{ $item->attributes['restaurant']['id'] }})">
                                                    <ion-icon name="add" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                                    <span class="sr-only">Add</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        <button class="flex justify-center items-center w-10 h-10 rounded-full p-2 bg-red-500 hover:bg-red-600 focus:ring-red-900 focus:ring-4"  data-modal-toggle="deleteModal-{{ $key }}">
                                            <ion-icon name="trash" class=""></ion-icon>
                                        </button>

                                        <div id="deleteModal-{{ $key }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
                                            <div class="relative p-4 w-full max-w-md h-auto">
                                                <!-- Modal content -->
                                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal-{{ $key }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <button data-modal-toggle="deleteModal-{{ $key }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                            No, cancel
                                                        </button>
                                                        <a href="{{ route('delete-cart', $key)}}" type="button" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                            Yes, I'm sure
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <input type="hidden" name="jam" value="{{ $item->attributes->jam }}" id=""> --}}
                        </ul>
                    @endforeach
                </div>

                {{-- Total Waktu --}}
                @foreach ($data_carts as $item)
                    @php
                    $totalLamaWaktu = 0;
                    
                    foreach ($data_carts as $item) {
                        $lamaWaktu = $item->attributes['restaurant']['lama_waktu'];
                        $totalLamaWaktu += $lamaWaktu;
                    }
                    
                    // Calculate hours and minutes
                    $hours = floor($totalLamaWaktu / 60);
                    $minutes = $totalLamaWaktu % 60;
                    
                    // Format the hours and minutes into a human-readable string
                    $timeFormatted = "";
                    
                    if ($hours > 0) {
                        $timeFormatted .= $hours . " jam ";
                    }
                    
                    if ($minutes > 0) {
                        $timeFormatted .= $minutes . " menit";
                    } else {
                        $timeFormatted .= "0 menit";
                    }
                    @endphp

                    {{-- <input type="hidden" name="total_lama_waktu" value="{{$totalLamaWaktu }}"> --}}
                    <input type="hidden" name="total_lama_waktu" value="{{$timeFormatted }}">
                @endforeach

                @if (Auth::user()->kode_meja == null )
                    <div class="text-left max-w-sm h-96 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700 mb-2 mt-2">
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
                                    <input id="takeaway-radio" required type="radio" value="Takeaway" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                </div>
                            </li>
    
                            <li class="py-3 sm:py-2" style="display: none;" id="meja-takeaway">
                                <div id="select-input-wrapper">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Untuk Takeaway</label>
                                    <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected>Pilih Meja Restaurant</option>
                                        @foreach ($meja_restaurants as $key => $meja_restaurant)
                                            <option value="{{ $meja_restaurant->nama }}">{{ $meja_restaurant->nama }}</option>
                                        @endforeach
                                    </select>
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
                                    <input id="dine-in-radio" required type="radio" value="Dine In" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                        </li>
                        <li class="py-3 sm:py-2" style="display: none;" id="meja-wrapper">
                            <div id="select-input-wrapper">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja</label>
                                <select id="meja_resto" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>Pilih Meja Restaurant</option>
                                    @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option value="{{ $meja_restaurant->nama }}">{{ $meja_restaurant->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        {{-- <li class="py-3 sm:py-2" id="meja-wrapper">
                            <div id="select-input-wrapper">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja</label>
                                <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>Pilih Meja Restaurant</option>
                                    @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option value="{{ $meja_restaurant->id }}" {{ old('meja_restaurant_id') == $meja_restaurant->id ? 'selected' : '' }}>{{ $meja_restaurant->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li> --}}

                        <li class="py-3 sm:py-2" id="voucher-get" style="display: none;">
                            <div id="select-input-wrapper">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Voucher</label>
                                <select id="voucher" name="voucher" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Pilih Voucher</option> <!-- Use an empty value -->
                                    @foreach ($vouchers as $key => $voucher)
                                        @if ($voucher->status == true)
                                        <option required value="{{ $voucher->id }}">{{ $voucher->code }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li>
                            <div class="flex items-center space-x-4" style="margin-top: 20px;">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Email 
                                    </p>
                                </div>
                            </div>
                            <input required placeholder="Ex: xxx@gmail.com" name="email" value="{{ old('email') }}" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                        </li>
                        </ul>
                    </div>
                    
                @else
                <div class="text-left max-w-sm h-96 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700 mb-2">
                    <div class="p-2 space-x-4">
                        <p class="text-lg font-semibold text-center dark:text-white">Pilih Category</p>
                    </div>
                    
                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                    <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700 px-3">
                        @if($meja == "takeaway")
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
                                    <input checked id="takeaway-radio" required type="radio" value="Takeaway" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                </div>
                            </li>

                            <li class="py-3 sm:py-2" style="display: none;" id="meja-takeaway">
                                <div id="select-input-wrapper">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Untuk Takeaway</label>
                                    <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected>Pilih Meja Restaurant</option>
                                        @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option required value="{{ $meja_restaurant->nama }}" {{ $kodeMeja == $meja_restaurant->kode_meja ? 'selected' : '' }}>{{ $meja_restaurant->nama }}</option>
                                        @endforeach
                                    </select>
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
                                        <input id="dine-in-radio" required type="radio" value="Dine In" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-2" style="" id="meja-wrapper">
                                <div id="select-input-wrapper">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja</label>
                                    <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected>Pilih Meja Restaurant</option>
                                        @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option required value="{{ $meja_restaurant->nama }}" {{ $kodeMeja == $meja_restaurant->kode_meja ? 'selected' : '' }}>{{ $meja_restaurant->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>

                            @else
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
                                    <input checked id="takeaway-radio" required type="radio" value="Takeaway" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                </div>
                            </li>

                            <li class="py-3 sm:py-2" style="display: none;" id="meja-takeaway">
                                <div id="select-input-wrapper">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Untuk Takeaway</label>
                                    <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected>Pilih Meja Restaurant</option>
                                        @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option required value="{{ $meja_restaurant->nama }}" {{ $kodeMeja == $meja_restaurant->kode_meja ? 'selected' : '' }}>{{ $meja_restaurant->nama }}</option>
                                        @endforeach
                                    </select>
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
                                        <input checked id="dine-in-radio" required type="radio" value="Dine In" name="category" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-2" style="" id="meja-wrapper">
                                <div id="select-input-wrapper">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja</label>
                                    <select id="countries" name="meja_restaurant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected>Pilih Meja Restaurant</option>
                                        @foreach ($meja_restaurants as $key => $meja_restaurant)
                                        <option required value="{{ $meja_restaurant->nama }}" {{ $kodeMeja == $meja_restaurant->kode_meja ? 'selected' : '' }}>{{ $meja_restaurant->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                        @endif
                        <a href="{{ route('reset-meja') }}" >
                            <button type="button" class="w-full h-full p-3 bg-blue-500 dark:text-white mt-auto rounded-[30px] hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Reset Meja</button>
                        </a>

                        {{-- Voucher --}}
                        <li class="py-3 sm:py-2" id="voucher-get" style="display: none;" >
                            <div id="select-input-wrapper">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Voucher</label>
                                <select id="voucher" name="voucher" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Pilih Voucher</option> <!-- Use an empty value -->
                                    @foreach ($vouchers as $key => $voucher)
                                        @if ($voucher->status == true)
                                        <option required value="{{ $voucher->id }}">{{ $voucher->code }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </li>

                    </ul>
                    
                </div>
                @endif

                {{-- Untuk Waiters --}}
                @if (Auth::user()->is_worker == true )
                <div class="text-left max-w-sm h-64 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-2 space-x-4">
                        <p class="text-lg font-semibold text-center dark:text-white">Pilih Exclusive Order</p>
                    </div>
                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                    <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700 px-3">
                        {{-- <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/edc.png') }}" alt="Neil image">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Payment Gateaway Online
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input required type="radio" id="payment_gateaway" value="Payment Gateaway Online" name="tipe_pemesanan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            </div>
                        </li> --}}

                        {{-- <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/edc.png') }}" alt="Neil image">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Bank BJB Testing
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input required type="radio" id="payment_gateaway" value="QR-BJB" name="tipe_pemesanan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            </div>
                        </li> --}}

                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/edc.png') }}" alt="Neil image">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Bank BRI
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input required type="radio" id="payment_gateaway" value="QR-BRI" name="tipe_pemesanan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            </div>
                        </li>


                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/pos.png') }}" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        EDC
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    <input required type="radio" id="edisi" name="tipe_pemesanan" value="Edisi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                        </li>

                        <li class="py-3 sm:py-2" style="display:none;" id="edisi-pembayaran">
                            <div id="select-input-wrapper">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih EDC</label>
                                <select id="countries" name="metode_edisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>Pilih EDC</option>
                                    <option value="EDC MANDIRI">EDC MANDIRI</option>
                                    <option value="EDC BCA">EDC BCA</option>
                                    <option value="EDC BRI">EDC BRI</option>
                                    <option value="EDC BNI">EDC BNI</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="text-left max-w-sm bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700" style="height: 26rem;">
                    <div class="p-2 space-x-4">
                        <p class="text-lg font-semibold text-center dark:text-white">Isi Data Informasi Order</p>
                    </div>
                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                    <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700 px-3">
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Masukan Nama Customer
                                </p>
                            </div>
                            </div>
                            <input placeholder="Massukan Nama" required name="nama" id="" value="{{ old('nama') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                        </li>
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Masukan No Tlp <small>(Optional)</small>
                                    </p>
                                </div>
                            </div>
                            <input placeholder="Massukan No Tlp" name="phone" value="{{ old('phone') }}" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                        </li>

                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Masukan Jumlah Customer /Table 
                                    </p>
                                </div>
                            </div>
                            <input type="number" min="0" placeholder="Massukan Jumlah Customer/Table" name="jumlah_customer" value="{{ old('jumlah_customer') }}" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('jumlah_customer') is-invalid @enderror">
                        </li>

                        <li class="py-3 sm:py-2">
                            <div id="select-input-wrapper">
                                <label for="kasir_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Nama Kasir</label>
                                <select id="kasir_id" name="kasir_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mt-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>Pilih Nama Kasir</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->name }}" {{ old('kasir_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
                @endif
            </div>

            <div class="max-w-full mt-2 max-h-[25rem] bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700 sm:mt-3">
                <div class="p-3 space-x-4">
                    <p class="text-lg font-semibold text-center dark:text-white">Order Summary</p>
                </div>
                <ul class="max-w-full divide-y divide-gray-200 dark:divide-gray-700 px-3">
                    {{-- super platinum --}}

                    @if (Auth::user()->membership->level == 'Super Platinum')
                    <li class="py-3 sm:py-3">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Subtotal
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="subtotal-summary">
                                Rp. 1
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-3">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Service {{ $order_settings[0]->layanan }}%
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="service-summary">
                                <?php
                                    $biaya_layanan = number_format((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100,0 );
                                ?>
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
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="PB01-summary">
                                <?php
                                    $biaya_pb01 = number_format(((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0);
                                ?>

                                Rp. 1 
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-3" style="display: none;" id="packing">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Packing
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="PB01-summary">
                                <input type="hidden" name="packing" >
                                Rp. 1 
                            </div>
                        </div>
                    </li>
                    
                    {{-- <li class="py-3 sm:py-3" id="voucher-summary" style="display: none;">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                                    Diskon Voucher
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="voucher-price">
                            </div>
                        </div>
                    </li> --}}

                    <input type="hidden" id="voucher-price-input" name="voucher_diskon">

                    <li class="py-3 sm:py-3" id="order-total" style="display: none;">
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
                    <input type="hidden" id="order-total-input" name="order_total">

                    {{-- order total without package --}}
                    <li class="py-3 sm:py-3" id="order-total-packing" style="display: none;">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                                    Order Total
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                <?php
                                    $packing = 5000;
                                    $totalWithoutPacking = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100;
                                    $totalWithPacking = $totalWithoutPacking + $packing;
                                ?>
                                Rp. 1
                            </div>
                        </div>
                    </li>

                    @elseif(Auth::user()->telephone == '081210469621')
                    {{-- --------------------------------Bu Fitri ----------------------------------- --}}
                    <li class="py-3 sm:py-3">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Subtotal
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="subtotal-summary">
                                Rp. {{ number_format(\Cart::getTotal()  ?? '0',0 ) }}
                            </div>
                        </div>
                    </li>

                    {{-- ------------------------------User Normal-------------------------------------- --}}
                    @else
                    <li class="py-3 sm:py-3">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Subtotal
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="subtotal-summary">
                                Rp. {{ number_format(\Cart::getTotal()  ?? '0',0 ) }}
                                {{-- <span id="total-subtotal" class="text-white">Rp. 0</span> --}}
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-3">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Service {{ $order_settings[0]->layanan }}%
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="service-summary">
                                <?php
                                    $biaya_layanan = number_format((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100,0 );
                                ?>
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
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="PB01-summary">
                                <?php
                                    $biaya_pb01 = number_format(((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0);
                                ?>

                                Rp. {{ $biaya_pb01 }} 
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-3" style="display: none;" id="packing">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                    Packing
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white" id="PB01-summary">
                                <input type="hidden" name="packing" >
                                Rp. 5,000 
                            </div>
                        </div>
                    </li>
                    
                    {{-- <li class="py-3 sm:py-3" id="voucher-summary" style="display: none;">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                                    Diskon Voucher
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="voucher-price">
                            </div>
                        </div>
                    </li> --}}

                    <input type="hidden" id="voucher-price-input" name="voucher_diskon">

                    <li class="py-3 sm:py-3" id="order-total" style="display: none;">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                                    Order Total
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white" id="total-order-summary">
                                @if (\Cart::getTotal())
                                Rp. {{ number_format((\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0)}}
                                @else
                                Rp. 0
                                @endif
                            </div>
                        </div>
                    </li>
                    <input type="hidden" id="order-total-input" name="order_total">

                    {{-- order total without package --}}
                    <li class="py-3 sm:py-3" id="order-total-packing" style="display: none;">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 truncate dark:text-white">
                                    Order Total
                                </p>
                            </div>
                            <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                <?php
                                    $packing = 5000;
                                    $totalWithoutPacking = (\Cart::getTotal() + (\Cart::getTotal() ?? 0) * $order_settings[0]->layanan/100);
                                    $totalWithPacking = $totalWithoutPacking + ($totalWithoutPacking + (\Cart::getTotal() ?? 0) * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100 + $packing;
                                ?>
                                @if (\Cart::getTotal())
                                {{-- Rp. {{ number_format((\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0)}} --}}
                                Rp. {{ number_format($totalWithPacking, 0) }}
    
                                @else
                                Rp. 0
                                @endif
                            </div>
                        </div>
                    </li>
                    @endif
                    

                </ul>
                <div class="mt-2">
                    {{-- <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" onclick="pushData()">Checkout</button> --}}
                    <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
                </div>
            </div>
        </form>
    @else
    <div class="w-100 h-96 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
        <img src="{{ asset('images/empty-cart.png') }}" width="25%">
        <h3>Keranjangmu Kosong, Harap masukkan product terlebih dahulu</h3>
    </div>
    @endif
</section>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')

{{-- Voucher --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil elemen-elemen yang diperlukan
        var selectMeja = document.getElementById("meja_resto");
        var mejaRestaurants = <?php echo json_encode($meja_restaurants); ?>; // Anda mungkin perlu mengubah ini sesuai dengan cara meja_restaurants diambil di halaman Anda

        // Fungsi untuk menampilkan alert
        function showAlert(message) {
            alert(message);
        }

        // Event listener untuk perubahan pada select element
        selectMeja.addEventListener("change", function () {
            var selectedMeja = selectMeja.value;

            // Temukan meja restoran yang sesuai dengan yang dipilih
            var matchingMeja = mejaRestaurants.find(function (meja) {
                return meja.nama === selectedMeja;
            });

            if (matchingMeja) {
                var minimalOrder = matchingMeja.minimal_order; // Gantilah 'minimum_order' dengan properti yang sesuai dari meja restoran

                // Cek jika meja sesuai dengan persyaratan minimal
                if (minimalOrder && minimalOrder <= <?php echo Cart::getTotal(); ?>) {
                    // showAlert("Meja ini Bisa");
                } else {
                    showAlert("Minimal Order Meja Ini Kurang");
                    selectMeja.value = "Pilih Meja Restaurant";
                }
            }
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const voucherSelect = document.getElementById("voucher");
        const voucherPriceDisplay = document.getElementById("voucher-price");
        const orderTotalDisplay = document.getElementById("total-order-summary");
        
        const orderTotalPackingDisplay = document.getElementById("total-order-summary-packing");

        const voucherPriceInput = document.getElementById("voucher-price-input");
        const orderTotalInput = document.getElementById("order-total-input");
        const orderTotalPackageInput = document.getElementById("order-total-package-input");

        const vouchers = {!! json_encode($vouchers) !!};
        const orderSettings = {!! json_encode($order_settings) !!};
        
        console.log(vouchers);
        
        voucherSelect.addEventListener("change", function() {
            const selectedVoucherId = voucherSelect.value;
            const selectedVoucher = vouchers.find(voucher => voucher.id == selectedVoucherId);
            const cartTotal = {!! json_encode(\Cart::getTotal()) !!};
            const layanan = orderSettings[0].layanan;
            const pb01 = orderSettings[0].pb01;        

            const cartTotalWithLayananCharge = ((cartTotal) + (cartTotal * layanan / 100) + ((cartTotal) + (cartTotal * layanan/100) ) * pb01/100);
            const roundedCartTotal = Math.round(cartTotalWithLayananCharge);

            const packaging = 5000;
            const cartTotalWithPackageCharge = ((cartTotal) + (cartTotal * layanan / 100) + ((cartTotal) + (cartTotal * layanan/100) ) * pb01/100)+packaging;
            const cartTotalPackage = Math.round(cartTotalWithPackageCharge);
            console.log('Cart Total Packaging' , cartTotalPackage);

            if (selectedVoucher) {
                const minimumTransaksi = parseFloat(selectedVoucher.minimum_transaksi); // Parse harga as a number
                console.log('Minimun Transaksi', minimumTransaksi);
                if (minimumTransaksi <= roundedCartTotal) {
                    // normal
                    const voucherHarga = parseFloat(selectedVoucher.harga); // Parse harga as a number
                    const discountAmount = voucherHarga;
                    voucherPriceDisplay.textContent = `Rp. ${discountAmount.toFixed(0)}`;
                    orderTotalDisplay.textContent = `Rp. ${(roundedCartTotal - discountAmount).toFixed(0)}`;
                    
                    orderTotalHidden = (roundedCartTotal - discountAmount);
                    orderTotalInput.value = orderTotalHidden;
                    console.log(orderTotalInput.value);
                    // With package
                    // orderTotalPackingDisplay.textContent = `Rp. ${(cartTotalPackage - discountAmount).toFixed(0)}`;
                    // orderTotalPackageInput.value = orderTotalHidden;
                    
                    voucherPriceInput.value = discountAmount;
                    console.log('Order Total hidden',orderTotalInput.value);
                } else {
                    voucherPriceDisplay.textContent = "0";
                    orderTotalDisplay.textContent = `Rp. ${roundedCartTotal.toFixed(0)}`;
                    orderTotalPackingDisplay.textContent = `Rp. ${cartTotalPackage.toFixed(0)}`;
                    const alertMessage = `Minimum transaksi ${minimumTransaksi} Anda kurang untuk menggunakan voucher ini.`;
                    alert(alertMessage);
                }


            } else {
                voucherPriceDisplay.textContent = "0";
                orderTotalDisplay.textContent = `Rp. ${roundedCartTotal.toFixed(0)}`;
                orderTotalPackingDisplay.textContent = `Rp. ${cartTotalPackage.toFixed(0)}`;
            }
        });
    });
</script>

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

    // Pilihan EDC
    if ($("#payment_gateaway").length) {
        const paymentGatewayRadio = document.getElementById('payment_gateaway');
        const edcRadio = document.getElementById('edisi');
        const edisiPembayaranWrapper = document.getElementById('edisi-pembayaran');
        paymentGatewayRadio.addEventListener('change', function() {
            if (this.checked) {
                edisiPembayaranWrapper.style.display = 'none';
            }
        });
    
        edcRadio.addEventListener('change', function() {
            if (this.checked) {
                edisiPembayaranWrapper.style.display = 'block';
            }
        });
    }

    // Packing

    document.addEventListener("DOMContentLoaded", function () {
        const takeawayRadio = document.getElementById("takeaway-radio");
        const dineInRadio = document.getElementById("dine-in-radio");
        const orderTotal = document.getElementById("order-total");
        const orderTotalPacking = document.getElementById("order-total-packing");
        const voucherCoupon = document.getElementById("voucher-summary");
        const voucherGet = document.getElementById("voucher-get");

        if (takeawayRadio && dineInRadio && orderTotal && orderTotalPacking) {
            takeawayRadio.addEventListener("change", function () {
                orderTotal.style.display = "none";
                // voucherCoupon.style.display = "none";
                voucherGet.style.display = "none";
                orderTotalPacking.style.display = "block";
            });

            dineInRadio.addEventListener("change", function () {
                orderTotal.style.display = "block";
                // voucherCoupon.style.display = "block";
                voucherGet.style.display = "block";
                orderTotalPacking.style.display = "none";
            });

            if (dineInRadio.checked) {
                orderTotal.style.display = "block";
                voucherCoupon.style.display = "block";
                voucherGet.style.display = "block";
                orderTotalPacking.style.display = "none";
            }
        }
    });

    const getDataCart = {!! json_encode($data_carts) !!};
    const otherSetting = {!! json_encode($order_settings[0]) !!};

    // // Mengambil elemen radio button "Takeaway" dan "Dine In"
    const takeawayRadio = document.getElementById('takeaway-radio');
    const dineInRadio = document.getElementById('dine-in-radio');

    // Mengambil elemen wrapper "Pilih Meja"
    const mejaWrapper = document.getElementById('meja-wrapper');
    const mejaTakeaway = document.getElementById('meja-takeaway');
    const packing = document.getElementById('packing');
    const packingInput = document.querySelector('input[name="packing"]');

    // Menambahkan event listener saat radio button berubah
    takeawayRadio.addEventListener('change', toggleMejaWrapper);
    dineInRadio.addEventListener('change', toggleMejaWrapper);

    // Fungsi untuk mengubah visibilitas "Pilih Meja"
    function toggleMejaWrapper() {
        if (takeawayRadio.checked) {
            mejaWrapper.style.display = 'none';
            mejaTakeaway.style.display = 'block';
            packing.style.display = 'block';
            packingInput.value = '5000';
        } else if (dineInRadio.checked) {
            mejaWrapper.style.display = 'block';
            mejaTakeaway.style.display = 'none';
            packing.style.display = 'none';
            packingInput.value = '0';
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

    function add(slug, id){
        getVar = getValueAndUpdatePlus(slug);
        let currentPrice = calculateTotalPrice(getDataCart).toLocaleString('id-ID');
        let layanan = (currentPrice * (otherSetting.layanan / 100)).toFixed(3);
        let pb01 = ((parseFloat(currentPrice) + parseFloat(layanan)) * (otherSetting.pb01 / 100)).toFixed(3);
        let totalOrder = (parseFloat(currentPrice) + parseFloat(layanan) + parseFloat(pb01)).toFixed(3);
        let packaging = (otherSetting.biaya_packing).toLocaleString('id-ID');
        let totalOrderPacking = (parseFloat(currentPrice) + parseFloat(layanan) + parseFloat(pb01) + parseFloat(packaging)).toFixed(3);
        console.log(packaging, currentPrice);

        const subtotalElement = document.getElementById('subtotal-summary');
        subtotalElement.textContent = `Rp. ${currentPrice}`;

        const serviceElement = document.getElementById('service-summary');
        serviceElement.textContent = `Rp. ${layanan.toLocaleString('id-ID')} `;

        const pb01Element = document.getElementById('PB01-summary');
        pb01Element.textContent = `Rp. ${pb01.toLocaleString('id-ID')} `;

        const totalOrderElement = document.getElementById('total-order-summary');
        totalOrderElement.textContent = `Rp. ${totalOrder.toLocaleString('id-ID')} `;

        const totalOrderPackingElement = document.getElementById('total-order-summary-packing');
        totalOrderPackingElement.textContent = `Rp. ${totalOrderPacking.toLocaleString('id-ID')} `;
    }

    function getValueAndUpdateMin(slug) {
        let getVar = parseFloat($('.counter-' + slug).val()) || 1;
        getVar = Math.max(1, getVar - 1);
        $('.counter-' + slug).val(getVar);

        return getVar;
    }
    function getValueAndUpdatePlus(slug) {
        let getVar = parseFloat($('.counter-' + slug).val()) || 1;
        getVar = Math.max(1, getVar + 1);
        $('.counter-' + slug).val(getVar);

        return getVar;
    }

    function remove(slug, $id) {
        const getVar = getValueAndUpdateMin(slug);
        // const valueUpdate = updateCartData(getDataCart, slug, getVar, $id);

        // console.log(valueUpdate);
        // Update subtotal after removing an item
        let currentPrice = calculateTotalPrice(getDataCart).toLocaleString('id-ID');
        let layanan = (currentPrice * (otherSetting.layanan / 100)).toFixed(3);
        let pb01 = ((parseFloat(currentPrice) + parseFloat(layanan)) * (otherSetting.pb01 / 100)).toFixed(3);
        let totalOrder = (parseFloat(currentPrice) + parseFloat(layanan) + parseFloat(pb01)).toFixed(3);
        let packaging = (otherSetting.biaya_packing).toLocaleString('id-ID');
        let totalOrderPacking = (parseFloat(currentPrice) + parseFloat(layanan) + parseFloat(pb01) + parseFloat(packaging)).toFixed(3);
        console.log(packaging, currentPrice);

        const subtotalElement = document.getElementById('subtotal-summary');
        subtotalElement.textContent = `Rp. ${currentPrice}`;

        const serviceElement = document.getElementById('service-summary');
        serviceElement.textContent = `Rp. ${layanan.toLocaleString('id-ID')} `;

        const pb01Element = document.getElementById('PB01-summary');
        pb01Element.textContent = `Rp. ${pb01.toLocaleString('id-ID')} `;

        const totalOrderElement = document.getElementById('total-order-summary');
        totalOrderElement.textContent = `Rp. ${totalOrder.toLocaleString('id-ID')} `;

        const totalOrderPackingElement = document.getElementById('total-order-summary-packing');
        totalOrderPackingElement.textContent = `Rp. ${totalOrderPacking.toLocaleString('id-ID')} `;
    }

    // Function to calculate total price from cart data
    function calculateTotalPrice(dataCart) {
        let total = 0;
        for (const key in dataCart) {
            const nestedObject = dataCart[key];
            let slugToFind = key.toLowerCase().replace(/\s+/g, "-");
            let getVar = parseFloat($('.counter-' + slugToFind).val()) || 0;
            total += nestedObject.price * getVar;
        }
        return total;
    }
 </script>


@endpush
