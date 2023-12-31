@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
<section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-36 overflow-hidden rounded-2xl shadow-2xl md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1563897539633-7374c276c212?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1046&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1466814314367-45323ac74e2b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2085&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1545062080-a71640ea75a1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            <button type="button" class="w-2 h-2 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>
    </div>
</section>

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">Detail Paket Menu</span>
        </div>
    </div>
    <form action="{{ route('checkout-meeting',$paket_menu->id) }}" method="POST">
        @csrf
    <div class="grid grid-cols-1">
        <div class="text-base sm:text-sm px-1 py-3 w-full">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                {{-- <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full"> --}}
                <img src="{{ $image.$paket_menu->image ?? 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1">
        <div class="px-1 w-full">
            {{-- <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $paket_menu->nama_paket ?? 'Error' }}</p> --}}
            <p aria-hidden="true" class="text-lg mt-1 font-semibold dark:text-gray-300">{{ $paket_menu->nama_paket ?? 'Error' }} </p> <br>
            <span class="block text-[15px] dark:text-red-500">Rp.{{ number_format($paket_menu->harga,2) }} </span>
            <input type="hidden" name="total_paket" value="{{ $paket_menu->harga }}">

            <p aria-hidden="true" class="text-lg mt-1 font-semibold dark:text-gray-300">Bonus Paket </p>
                @foreach ($restaurants as $restaurant)
                    @foreach (old('restaurant_id') ?? $menu_package_pivots as $id)
                        @if ($id == $restaurant->id)
                            <div class="flex gap-1 opacity-75 mt-auto w-full">
                                <div class="grid space-y-3">
                                    <input type="hidden" name="nama_resto[]" value="{{ $restaurant->nama ?? '' }}" id="">
                                    {{-- <input type="hidden" name="harga_paket[]" value="{{ $restaurant->harga ?? 0 }}" id=""> --}}
                                    {{-- <input type="hidden" name="category[]" value="{{ $restaurant->category }}"> --}}
                                    <input type="hidden" name="category_paket[]" value="{{ $restaurant->category ?? '' }}">
                                    
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5 mt-1">
                                            <input id="hs-checkbox-delete" value="{{ $restaurant->id }}" name="paket_restaurant_id[]" type="checkbox" class="{{ str_replace(' ', '-', strtolower($restaurant->nama)) }} border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-checkbox-delete-description">
                                        </div>
                                        <label for="hs-checkbox-delete" class="ml-3">
                                            {{-- <span class="block text-sm font-semibold text-gray-800 dark:text-gray-300">{{ $restaurant->title }}</span> --}}
                                            <span id="hs-checkbox-delete-description" class="text-sm text-gray-600 dark:text-gray-300">{{ $restaurant->nama ?? '' }}</span> <br>
                                            {{-- <span id="hs-checkbox-delete-description" class="text-sm text-gray-600 dark:text-gray-300">Rp. {{ number_format($restaurant->harga ?? '',0) }}</span> --}}
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>
                        @endif
                        @endforeach
                @endforeach

        </div>
    </div>

    <div class="max-w-full mt-2 h-64 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 space-x-4">
            <p class="text-lg font-semibold text-center dark:text-white">Schedule & Table Billiard</p>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div class="mt-3">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Meeting</label>
                <select id="meeting_room_id" name="meeting_room_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="disableHour()">
                    <option disabled selected>Pilih Meja Meeting</option>
                    @foreach ($meeting_rooms as $key => $meeting_room)
                        <option value="{{ $meeting_room->id }}">{{ $meeting_room->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <label for="countries" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>                    
                <input type="date" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="disableHour()" value="{{ date('Y-m-d') }}">
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
            
            
            
        </div>
    </div>
    
    
        <div class="mt-2">
            <input type="hidden" name="id" value="{{ $paket_menu->id }}" id="">
            <input type="hidden" name="nama" value="{{ $paket_menu->nama_paket }}" id="">
            <input type="hidden" name="harga" value="{{ $paket_menu->harga }}" id="">
            <input type="hidden" name="image" value="{{ $image.$paket_menu->image }}" id="">
            <input type="hidden" name="jam" value="{{ $paket_menu->jam }}" id="">
            <input type="hidden" name="quantity" value="1" id="">
            <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
        </div>
    </form>
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
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });

    function add(slug, $id){
        let getVar = parseInt($('.counter').val());
        if(!getVar || getVar == NaN){
            getVar = 1;
            $('.counter').val(getVar);
        }else{
            getVar = getVar + 1;
            $('.counter').val(getVar);
        }

        // $.ajax({
        //     type: 'POST',
        //     url: "{{ route('cart-update') }}",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //         "qty": getVar,
        //         "id": $id
        //     },
        //     success: function (data) {
        //         // location.reload();
        //         // window.location.href(url)
        //     },
        //     error: function (data) {
        //         $.alert('Failed!');
        //         console.log(data);
        //     }
        // });
    }

    function remove(slug, $id){
        let getVar = parseInt($('.counter').val());
        if(!getVar || getVar == NaN){
            getVar = 0;
            $('.counter').val(getVar);
        }else{
            getVar = getVar - 1;
            $('.counter').val(getVar);
        }

    }

    function disableHour() {
        var valueDate = $('#date').val();
        var meetingId = $('#meeting_room_id').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('check-schedule-meeting') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
            "_token": "{{ csrf_token() }}",
            "date": valueDate,
            "meeting_room_id": meetingId
            },
            success: function (data) {
                console.log(data);
                $("#time_from option").attr('disabled', false);

                // Disable hours based on date
                data.times.forEach(element => {
                    $("#time_from option").attr('selected', false);
                    let valHourFrom = element.substring(0, 5);
                    $("#time_from option[value='" + valHourFrom + "']").attr('disabled', true);
                });

                // Disable hours based on billiard ID
                // data.billiards.forEach(billiard => {
                //     let valHourFrom = billiard.substring(0, 5);
                //     $("#time_from option[value='" + valHourFrom + "']").attr('disabled', true);
                // });
            },
            error: function (data) {
            $.alert('Failed!');
            console.log(data);
            }
        });
    }
 </script>
 {{-- Level Pedas --}}
 {{-- <script>
    const maxChecked2 = {{ $restaurant->nama }}; // Jumlah maksimum nilai yang dapat dicentang

    const checkboxes2 = document.querySelectorAll('.{{ str_replace(' ', '-', strtolower($restaurant->nama)) }}');
    let checkedCount2 = 0;

    checkboxes2.forEach(checkbox2 => {
        checkbox2.addEventListener('change', function() {
            if (this.checked) {
                checkedCount2++;
            } else {
                checkedCount2--;
            }

            if (checkedCount2 > maxChecked2) {
                this.checked = false; // Mencegah centangan lebih dari jumlah maksimum
                checkedCount2--;
            }
        });
    });
 </script> --}}
@endpush
