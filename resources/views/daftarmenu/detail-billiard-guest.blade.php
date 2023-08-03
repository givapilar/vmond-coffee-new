@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
{{-- <section class="p-3">
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
</section> --}}

<form action="{{ route('checkout-billiard-guest',md5(strtotime("now"))) }}" method="POST">
    @csrf
    <section class="p-3">
        <div class="text-left bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Detail Billiard</p>
            </div>

            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

            <input type="hidden" name="category" value="Paket Menu">
            
            <div class="grid grid-cols-1">
                <div class="text-base sm:text-sm px-1 py-3 w-full">
                    <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                        {{-- <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full"> --}}
                        <img src="{{ $image.$paket_menu->image ?? 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1">
                <div class="pt-2 pb-5 w-full">
                    <div class="px-5 mb-2">

                        <input type="hidden" name="paket_menu_id[]" value="{{ $paket_menu->id }}">
                        <p aria-hidden="true" class="text-lg font-semibold dark:text-gray-300">{{ $paket_menu->nama_paket ?? 'Error' }}</p>
                        <span class="block text-[15px] dark:text-red-500">Rp.{{ number_format($paket_menu->harga_diskon ?? 0, 2) }}</span>
                        <input type="hidden" name="total_paket" value="{{ $paket_menu->harga_diskon ?? 0 }}">
                    </div>

                    @for ($i = 1; $i <= $paket_menu->minimal; $i++)
                        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="mt-2 mb-2 flex justify-center items-center">
                            <p aria-hidden="true" class="text-md font-semibold dark:text-gray-300 text-center">Pilihan Makanan Dan Minuman </p>
                            <p aria-hidden="true" class="text-sm font-semibold dark:text-gray-300 text-center">&nbsp; (Pilihan {{ $i }})</p>
                        </div>
                        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                        @foreach ($restaurants as $restaurant)
                            <div id="select-input-wrapper">
                                @foreach (old('restaurant_id') ?? $menu_package_pivots as $id)
                                    @if ($id == $restaurant->id)
                                        @php
                                            $groupIdentifier = 'menu_' . $i; // Unique group identifier for radio buttons
                                        @endphp
                                        <div class="w-full" id="choice-{{ $i }}">
                                            <div class="relative flex items-center px-3 py-2" id="detail-{{ $i }}">
                                                <div class="flex items-center h-5">
                                                    <input id="choice-menu-{{ $restaurant->nama }}-{{ $i }}" type="radio" value="{{ $restaurant->id }}" name="paket_restaurant_id[{{ $groupIdentifier }}]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom">
                                                </div>
                                                <label for="choice-menu-{{ $restaurant->nama }}-{{ $i }}" class="ml-3">
                                                    <span id="choice-menu-{{ $restaurant->nama }}-{{ $i }}-description" class="text-sm text-white dark:text-white">{{ $restaurant->nama ?? '' }}</span> <br>
                                                </label>
                                            </div>
                                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                   @endfor
                </div>
            </div>
        </div>
    </section>

    <section class="p-3">
        <div class="mt-2 max-w-full mt-2 bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700" style="height: 18rem;">
            <div class="p-3">
                <p class="text-lg font-semibold text-center dark:text-white">Include Billiard</p>
                <p class="text-lg font-semibold text-center dark:text-white">Schedule & Table</p>
            </div>

            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

            <div class="grid grid-cols-2 gap-2 mb-2">
                <div class="mt-3">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Biliard</label>
                    <select id="billiard_id" required name="billiard_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="disableHour()">
                        <option disabled selected>Pilih Meja Biliard</option>
                        @foreach ($billiard as $key => $biliards)
                            <option value="{{ $biliards->id }}">{{ $biliards->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="date" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>
                    <input type="text" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ date('Y-m-d') }}">
                    {{-- <input type="date" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ date('Y-m-d') }}" onchange="toggleTimeFrom()"> --}}
                    {{-- <input datepicker datepicker-buttons type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"> --}}
                </div>
                
                <div class="mt-4" id="timeFromContainer" style="display: none;">
                    <label for="countries" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_weekdays" required name="time_from" class="time_from bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Select Time From</option>
                        <?php
                        $startTime = strtotime('09:00');
                        $endTime = strtotime('21:00');
                    
                        while ($startTime <= $endTime) {
                            $optionValue = date('H:i', $startTime);
                            echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                            $startTime = strtotime('+15 minutes', $startTime);
                        }
                        ?>
                    </select>
                </div>

                <div class="mt-4" id="weekend" style="display: none;">
                    <label for="countries" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_weekend" required name="time_from" class="time_from bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Select Time From</option>
                        <?php
                        $startTime = strtotime('07:00');
                        $endTime = strtotime('23:00');
                    
                        while ($startTime <= $endTime) {
                            $optionValue = date('H:i', $startTime);
                            echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                            $startTime = strtotime('+15 minutes', $startTime);
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="p-3 grid grid-cols-2 gap-3 sm:grid-cols-1">
        <div class="text-left h-72 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Informasi meja billiard</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <div class="">
                <img src="{{ asset('assetku/dataku/img/logo/layout.png') }}" alt="">
            </div>
        </div>
        <div class="text-left h-72 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Isi Data Informasi Order</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <ul class=" divide-y divide-gray-200 dark:divide-gray-700 px-3">
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            Massukan Nama 
                        </p>
                    </div>
                    </div>
                    <input placeholder="Massukan Nama" required name="nama_user" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                    
                </li>
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Massukan No Tlp
                            </p>
                        </div>
                    </div>
                    <input placeholder="Massukan No Tlp" required name="phone" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                    <small class="text-xs text-center dark:text-red-500">*Otomatis menjadi member (username dan password menggunakan nomer telephone)</small>
                </li>
            </ul>
        </div>
    </section>
    


    <section class="p-3" style="text-align: -webkit-center;">
        <div class="text-left bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3">
                <p class="text-lg font-semibold text-center dark:text-white">Order Summary</p>
            </div>

            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

            <ul class="divide-y divide-gray-200 dark:divide-gray-700 px-3 mt-2">
                <li class="py-3 sm:py-3">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-normal text-gray-900 truncate dark:text-white">
                                Sub Total
                            </p>
                        </div>
                        <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                            {{-- {{ number_format($paket_menu->harga_diskon  ?? '0',2 )  }} --}}
                            Rp. {{ number_format($paket_menu->harga_diskon ?? 0, 0) }}
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
                                $biaya_layanan = number_format(($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan/100,0 );
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
                            $biaya_pb01 = number_format((($paket_menu->harga_diskon   ?? '0') + ($paket_menu->harga_diskon  ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0);
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
                            @if ($paket_menu->harga_diskon)
                            {{-- Rp. {{ number_format($paket_menu->harga_diskon *$order_settings[0]->pb01/100 + $paket_menu->harga_diskon + $order_settings[0]->layanan ,0 ) }} --}}
                            {{-- Rp. {{ number_format($paket_menu->harga_diskon  ?? '0',0 ) }} --}}
                            Rp. {{ number_format(($paket_menu->harga_diskon + (($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan/100)) + (($paket_menu->harga_diskon  ?? '0') + ($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan/100) * $order_settings[0]->pb01/100,0)}}
                            @else
                            Rp. 0
                            @endif
                        </div>
                    </div>
                </li>
                
            </ul>

            <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
        </div>
    </section>

    <div class="mt-2">
        <input type="hidden" name="id" value="{{ $paket_menu->id }}" id="">
        <input type="hidden" name="nama" value="{{ $paket_menu->nama_paket }}" id="">
        <input type="hidden" name="harga" value="{{ $paket_menu->harga_diskon }}" id="">
        <input type="hidden" name="image" value="{{ $image.$paket_menu->image }}" id="">
        <input type="hidden" name="jam" value="{{ $paket_menu->jam }}" id="">
        <input type="hidden" name="quantity" value="1" id="">
    </div>
</form>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script>
    function pad(number) {
   return (number < 10) ? '0' + number : number;
 }

 // Function to generate time options for every 15 minutes
//   function generateTimeOptions() {
//     const startTime = 9; // Start hour (09:00)
//     const endTime = 23; // End hour (23:00)
//     const interval = 15; // Interval in minutes

//     const selectElement = document.getElementById("time_from_weekdays");

//     for (let hour = startTime; hour <= endTime; hour++) {
//       for (let minute = 0; minute < 60; minute += interval) {
//         const timeString = pad(hour) + ':' + pad(minute);
//         const option = document.createElement("option");
//         option.value = timeString;
//         option.text = timeString;
//         selectElement.appendChild(option);
//       }
//     }
//   }

//   // Call the function to generate time options
//   generateTimeOptions();
</script>
<script>
   disableByCurrentTimeWith15MinuteInterval()
   function disableByCurrentTimeWith15MinuteInterval() {
       const timeFromSelect = $("#time_from_weekdays");

       // Get the current time
       const currentTime = new Date();
       const currentHour = currentTime.getHours();
       const currentMinute = currentTime.getMinutes();

       // Calculate the nearest 15-minute interval in the future
       const intervalInMinutes = 15;
       let nearestInterval = Math.ceil(currentMinute / intervalInMinutes) * intervalInMinutes;
       if (nearestInterval === 60) {
           nearestInterval = 0;
       }

       // Loop through options and disable past hours and minutes
       timeFromSelect.find("option").each(function(i, elem) {
           const elHour = parseInt($(elem).val().split(":")[0]);
           const elMinute = parseInt($(elem).val().split(":")[1]);
           // console.log(elHour, elMinute);
           if (!isNaN(elHour) && !isNaN(elMinute)) {
               if (elHour < (currentHour -1) || (elHour === (currentHour -1) && elMinute < nearestInterval)) {
                   $(elem).attr('disabled', 'disabled');
               } else {
                   $(elem).removeAttr('disabled');
               }
           }
       });
       // Weekend
       const timeFromSelect2 = $("#time_from_weekend");

       // Get the current time
       const currentTime2 = new Date();
       const currentHour2 = currentTime2.getHours();
       const currentMinute2 = currentTime2.getMinutes();

       // Calculate the nearest 15-minute interval in the future
       const intervalInMinutes2 = 15;
       let nearestInterval2 = Math.ceil(currentMinute2 / intervalInMinutes2) * intervalInMinutes2;
       if (nearestInterval2 === 60) {
           nearestInterval2 = 0;
       }

       // Loop through options and disable past hours and minutes
       timeFromSelect2.find("option").each(function(i, elem) {
           const elHour2 = parseInt($(elem).val().split(":")[0]);
           const elMinute2 = parseInt($(elem).val().split(":")[1]);
           // console.log(elHour2, elMinute2);
           if (!isNaN(elHour2) && !isNaN(elMinute2)) {
               if (elHour2 < (currentHour2 -1) || (elHour2 === (currentHour2 -1) && elMinute2 < nearestInterval2)) {
                   $(elem).attr('disabled', 'disabled');
               } else {
                   $(elem).removeAttr('disabled');
               }
           }
       });

       // Select the first available future hour and minute (if any)
       // const firstEnabledOption = timeFromSelect.find("option:not(:disabled)").first();
       // if (firstEnabledOption.length > 0) {
       //     timeFromSelect.val(firstEnabledOption.val());
       // }
   }
// }); 
</script>

<script>
   function handleCheckboxChange(checkbox) {
       const maxChecks = parseInt(checkbox.dataset.maxChecks);
       const checkboxes = document.querySelectorAll('.checkbox-limit');

       let checkedCount = 0;
       checkboxes.forEach((cb) => {
           if (cb.checked) checkedCount++;
       });

       if (checkedCount > maxChecks) {
           checkbox.checked = false; // Prevent checking the checkbox if it exceeds the maximum limit
       }
   }

   // Add event listeners to all checkboxes with the 'checkbox-limit' class
   const checkboxes = document.querySelectorAll('.checkbox-limit');
   checkboxes.forEach((checkbox) => {
       checkbox.addEventListener('change', () => handleCheckboxChange(checkbox));
   });
   // Get the minimum limit from PHP variable or set a default value of 0
   // const minimumChecked = {{ $paket_menu->minimal ?? 0 }};
 
   // // Function to handle checkbox changes
   // function handleCheckboxChange(checkbox) {
   //     const checkboxes = document.querySelectorAll('input[type="checkbox"]');

   //     let checkedCount = 0;
   //     for (const cb of checkboxes) {
   //         if (cb.checked) checkedCount++;
   //     }

   //     for (const cb of checkboxes) {
   //         if (cb !== checkbox) {
   //             if (checkbox.checked && checkedCount >= minimumChecked) {
   //                 cb.disabled = true;
   //             } else {
   //                 cb.disabled = false;
   //             }
   //         }
   //     }
   // }

   // // Add event listeners to all checkboxes
   // const checkboxes = document.querySelectorAll('input[type="checkbox"]');
   // checkboxes.forEach((checkbox) => {
   //     checkbox.addEventListener('change', () => handleCheckboxChange(checkbox));
   // });
</script>
<script>
   function toggleTimeFrom() {
   const dateInput = document.getElementById('date');
   console.log(dateInput.value, 'tes');
   const dayOfWeek = new Date(dateInput.value).getDay();
   const timeFromContainer = document.getElementById('timeFromContainer');
   const weekend = document.getElementById('weekend');
   const timeFromWeekdaysSelect = document.getElementById('time_from_weekdays');
   const timeFromWeekendSelect = document.getElementById('time_from_weekend');
   var billiardSelect = document.getElementById('billiard_id');

   // if (billiardSelect.value != '') {
   //         timeFromContainer.style.display = 'block';
   //         weekendContainer.style.display = 'block';
   // }
   if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Monday to Friday (0 is Sunday, 1 is Monday, and so on)
       timeFromWeekendSelect.disabled = true;
       timeFromWeekdaysSelect.disabled = false;
       timeFromContainer.style.display = 'block';
       weekend.style.display = 'none';
   } else { // Saturday or Sunday
       timeFromWeekendSelect.disabled = false;
       timeFromWeekdaysSelect.disabled = true;
       timeFromContainer.style.display = 'none';
       weekend.style.display = 'block';
   }
}

// Call the function on page load to initialize the visibility of the "Select Time From" dropdown
// disableTimeFromIfNoBilliard();
toggleTimeFrom();

</script>


<script>
   // code sahri
   // function disableHour(){
   //     var valueDate = $('#date').val();
   //     var billiardId = $('#billiard_id').val();

   //     var getJam = {!! json_encode($paket_menu) !!};

   //     $.ajax({
   //         type: 'POST',
   //         url: "{{ route('check-schedule') }}",
   //         headers: {
   //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //         },
   //         data: {
   //             "_token": "{{ csrf_token() }}",
   //             "date": valueDate,
   //             "billiard_id": billiardId
   //         },
   //         success: function (data) {
   //             console.log(data);
   //             $("#time_from option").prop('disabled', false); // Use prop() instead of attr()

   //             // Get the current time
   //             const currentTime = new Date();
   //             const currentHour = currentTime.getHours();
   //             console.log(billiardId, valueDate);
   //             // data.times.forEach(element => {
   //             //     let valHourFrom = element.substring(0, 5);
   //             //     console.log((valHourFrom + getJam.jam));
   //             //     const hourPart = parseInt(valHourFrom.substring(0, 2), 10);
   //             //     console.log((hourPart + getJam.jam), currentHour);

   //             //     // Loop through options and disable past hours and the current hour
   //             //     const timeFromSelect = $(".time_from");
   //             //     timeFromSelect.find("option").each(function (i, elem) {
   //             //         const elid = parseInt($(elem).val());
   //             //         if (!isNaN(elid)) {
   //             //             if (elid < currentHour || hourPart === elid) {
   //             //                 console.log('test' + elid, 'test' + i, elem);
   //             //                 $(elem).prop('disabled', true); // Use prop() instead of attr()
   //             //             } else {
   //             //                 $(elem).prop('disabled', false); // Use prop() instead of removeAttr()
   //             //             }
   //             //         }
   //             //     });

   //             //     // Select the first available future hour (if any)
   //             //     const firstEnabledOption = timeFromSelect.find("option:not(:disabled)").first();
   //             //     if (firstEnabledOption.length > 0) {
   //             //         timeFromSelect.val(firstEnabledOption.val());
   //             //     }

   //             //     // Disable the option with the same value as valHourFrom
   //             //     $("#time_from option[value='" + valHourFrom + "']").prop('disabled', true); // Use prop() instead of attr()
   //             // });
   //         },
   //         error: function (data) {
   //             $.alert('Failed!');
   //             console.log(data);
   //         }
   //     });
   // }
   
   // var valueDate = $('#date').val();
   // var getJam = {!! json_encode($paket_menu) !!};
   // const timeFromSelect = $(".time_from");
   //             // Get the current time
   // const currentTime = new Date();
   // const currentHour = currentTime.getHours();
   // const hourPart = parseInt(valHourFrom.substring(0, 2), 10);
   // console.log((hourPart + getJam.jam) , currentHour);
   // // Loop through options and disable past hours
   // timeFromSelect.find("option").each(function(i, elem) {
   //     const elid = parseInt($(elem).val());
   //     if (elid != null && elid != NaN) {
   //         if (elid < currentHour - 1 || hourPart == elid ) {
   //             console.log('test'+elid, 'test'+i, elem);
   //             $(elem).attr('disabled', 'disabled');
   //         } else {
   //             $(elem).removeAttr('disabled');
   //         }
   //     }
   // });

   //     // Select the first available future hour (if any)
   // const firstEnabledOption = timeFromSelect.find("option:not(:disabled)").first();
   // if (firstEnabledOption.length > 0) {
   //     timeFromSelect.val(firstEnabledOption.val());
   // }
   // $("#time_from option[value='"+ valHourFrom + "']").attr('disabled', true); 


   function disableHour() {
       var valueDate = $('#date').val();
       var billiardId = $('#billiard_id').val();

       // Your AJAX code here to fetch data and perform necessary actions
       $.ajax({
           type: 'POST',
           url: "{{ route('check-schedule') }}",
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {
               "_token": "{{ csrf_token() }}",
               "date": valueDate,
               "billiard_id": billiardId
           },
           success: function (data) {
               // console.log(data);
               // Enable all options before disabling the appropriate ones
               $("#time_from_weekdays option").prop('disabled', false);
               $("#time_from_weekend option").prop('disabled', false);
               disableByCurrentTimeWith15MinuteInterval()
               // Get the current time
               const currentTime = new Date();
               const currentHour = currentTime.getHours();
               
               for (const index in data.timeFrom) {
                   const dateFrom = data.timeFrom[index];
                   console.log(dateFrom);
                   const dateTo = data.timeTo[index];
                   let valHourFrom = dateFrom.substring(0, 5);
                   let valHourTo = dateTo.substring(0, 5);
                   const hourPart = parseInt(valHourFrom.substring(0, 2), 10);

                   // Loop through options and disable past hours and the current hour for weekdays
                   const timeFromWeekdaysSelect = $("#time_from_weekdays");
                   for (const i in timeFromWeekdaysSelect[0].options) {
                       const elem = timeFromWeekdaysSelect[0].options[i];
                       const elid = parseInt($(elem).val());
                       if (!isNaN(elid)) {
                           if (elid < currentHour || hourPart === elid) {
                               $(elem).prop('disabled', true);
                           } else {
                               $(elem).prop('disabled', false);
                           }

                           // Check if there are dateFrom and dateTo
                           if (dateFrom && dateTo) {
                               const elemHour = parseInt($(elem).val().split(":")[0]);
                               const elemMinute = parseInt($(elem).val().split(":")[1]);

                               const fromHour = parseInt(dateFrom.split(":")[0]);
                               const fromMinute = parseInt(dateFrom.split(":")[1]);

                               const toHour = parseInt(dateTo.split(":")[0]);
                               const toMinute = parseInt(dateTo.split(":")[1]);
                               console.log('From',fromHour);

                               // Check if the current option time is within the dateFrom and dateTo range
                               if (
                                   (elemHour === fromHour && elemMinute >= fromMinute) ||
                                   (elemHour === toHour && elemMinute <= toMinute) ||
                                   (elemHour > fromHour && elemHour < toHour)
                               ) {
                                   // console.log(fromHour, fromMinute, fromMinute, toMinute);
                                   $(elem).prop('disabled', true);
                               }
                           }
                       }
                   }

                   // Loop through options and disable past hours and the current hour for weekends
                   const timeFromWeekendSelect = $("#time_from_weekend");
                   for (const i in timeFromWeekendSelect[0].options) {
                       const elem = timeFromWeekendSelect[0].options[i];
                       const elid = parseInt($(elem).val());
                       if (!isNaN(elid)) {
                           if (elid < currentHour || hourPart === elid) {
                               $(elem).prop('disabled', true);
                           } else {
                               $(elem).prop('disabled', false);
                           }

                           // Check if there are dateFrom and dateTo (similar to the weekdays section)
                           if (dateFrom && dateTo) {
                               const elemHour = parseInt($(elem).val().split(":")[0]);
                               const elemMinute = parseInt($(elem).val().split(":")[1]);

                               const fromHour = parseInt(dateFrom.split(":")[0]);
                               const fromMinute = parseInt(dateFrom.split(":")[1]);

                               const toHour = parseInt(dateTo.split(":")[0]);
                               const toMinute = parseInt(dateTo.split(":")[1]);

                               // Check if the current option time is within the dateFrom and dateTo range
                               if (
                                   (elemHour === fromHour && elemMinute >= fromMinute) ||
                                   (elemHour === toHour && elemMinute <= toMinute) ||
                                   (elemHour > fromHour && elemHour < toHour)
                               ) {
                                   $(elem).prop('disabled', true);
                               }
                           }
                       }
                   }

                   // Select the first available future hour (if any) for weekdays
                   const firstEnabledOptionWeekdays = timeFromWeekdaysSelect.find("option:not(:disabled)").first();
                   if (firstEnabledOptionWeekdays.length > 0) {
                       timeFromWeekdaysSelect.val(firstEnabledOptionWeekdays.val());
                   }

                   // Select the first available future hour (if any) for weekends
                   const firstEnabledOptionWeekend = timeFromWeekendSelect.find("option:not(:disabled)").first();
                   if (firstEnabledOptionWeekend.length > 0) {
                       timeFromWeekendSelect.val(firstEnabledOptionWeekend.val());
                   }

                   // Disable the option with the same value as valHourFrom for weekdays
                   $("#time_from_weekdays option[value='" + valHourFrom + "']").prop('disabled', true);
                   // Disable the option with the same value as valHourFrom for weekends
                   $("#time_from_weekend option[value='" + valHourFrom + "']").prop('disabled', true);
               }


           },
           error: function (data) {
               console.log(data);
           }
       });
   }






   
   // $.ajax({
   //     type: 'POST',
   //     url: "{{ route('check-schedule') }}",
   //     headers: {
   //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //     },
   //     data: {
   //         "_token": "{{ csrf_token() }}",
   //         "date": valueDate
   //     },
   //     success: function (data) {
   //         console.log(data);
   //         $("#time_from option").attr('disabled', false); 
   //         data.times.forEach(element => {
   //             let valHourFrom = element.substring(0, 5);
   //             console.log((valHourFrom + getJam.jam));
   //             // console.log(element);
               
   //     },
   //     error: function (data) {
   //         $.alert('Failed!');
   //         console.log(data);
   //     }
   // });
   // });


   // function disableHour() {
   //     var valueDate = $('#date').val();
   //     var billiardId = $('#billiard_id').val();

   //     $.ajax({
   //         type: 'POST',
   //         url: "{{ route('check-schedule') }}",
   //         headers: {
   //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //         },
   //         data: {
   //         "_token": "{{ csrf_token() }}",
   //         "date": valueDate,
   //         "billiard_id": billiardId
   //         },
   //         success: function (data) {
   //             console.log(data);
   //             $("#time_from option").attr('disabled', false);

   //             // Disable hours based on date
   //             data.times.forEach(element => {
   //                 $("#time_from option").attr('selected', false);
   //                 let valHourFrom = element.substring(0, 5);
   //                 $("#time_from option[value='" + valHourFrom + "']").attr('disabled', true);
   //             });

   //             // Disable hours based on billiard ID
   //             // data.billiards.forEach(billiard => {
   //             //     let valHourFrom = billiard.substring(0, 5);
   //             //     $("#time_from option[value='" + valHourFrom + "']").attr('disabled', true);
   //             // });
   //         },
   //         error: function (data) {
   //         $.alert('Failed!');
   //         console.log(data);
   //         }
   //     });
   // }



</script>  
{{-- <script>
   function disableHour() {
       const dateInput = document.getElementById('date');
       const dayOfWeek = new Date(dateInput.value).getDay();
       const timeFromSelect = document.getElementById('time_from');
       
       // Enable all options by default
       timeFromSelect.querySelectorAll('option').forEach(option => {
           option.disabled = false;
       });

       if (dayOfWeek === 0 || dayOfWeek === 6) { // Saturday (0) and Sunday (6)
           // Disable options before 7 AM (07:00)
           timeFromSelect.querySelectorAll('option').forEach(option => {
               if (option.value < '07:00') {
                   option.disabled = true;
               }
           });
       }
   }
</script> --}}
<script>
   // sahri
   // Mendapatkan elemen input date dari dokumen
   // const inputDate = document.getElementById('date');

   // // Mendapatkan tanggal saat ini
   // const today = new Date();
   
   // // Menambahkan satu hari ke tanggal saat ini
   // const tomorrow = new Date(today);
   // tomorrow.setDate(tomorrow.getDate() + 1);

   // // Format tanggal menjadi YYYY-MM-DD untuk input date
   // const formattedTomorrow = tomorrow.toISOString().split('T')[0];
   // // console.log(inputDate.value);
   // // Tetapkan tanggal saat ini sebagai nilai minimal
   // inputDate.min = today.toISOString().split('T')[0];

   // // Tetapkan tanggal +1 hari sebagai nilai maksimal
   // inputDate.max = formattedTomorrow;

   // const inputDate = document.getElementById('date');
   // const today = new Date();
   // const tomorrow = new Date(today);
   // tomorrow.setDate(tomorrow.getDate() + 1);

   // // Format tanggal menjadi YYYY-MM-DD untuk input date
   // const formattedToday = today.toISOString().split('T')[0];
   // // console.log(formattedToday);
   // const formattedTomorrow = tomorrow.toISOString().split('T')[0];

   // // Tetapkan tanggal saat ini sebagai nilai minimal
   // inputDate.min = formattedToday;

   // // Tetapkan tanggal +1 hari sebagai nilai maksimal
   // inputDate.max = formattedTomorrow;



</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script> --}}
{{-- <script src="https://unpkg.com/js-datepicker/dist/datepicker.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.2.0/luxon.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/js/main.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script>
   // Step 3: Initialize Flatpickr on the input field
   // const inputDate = document.getElementById('date');
   // const today = new Date();
   // const tomorrow = new Date(today);
   // tomorrow.setDate(tomorrow.getDate() + 1);

   // // Format tanggal menjadi YYYY-MM-DD untuk input date
   // const formattedToday = today.toISOString().split('T')[0];
   // const formattedTomorrow = tomorrow.toISOString().split('T')[0];

   // // Initialize Flatpickr
   // flatpickr(inputDate, {
   //     minDate: formattedToday,
   //     maxDate: formattedTomorrow,
   //     dateFormat: "Y-m-d",
   //     disableMobile: true, // To ensure a better experience on mobile devices
   // });

   // flatpickr('#date', {
   //     minDate: 'today', // Today's date as the minimum date
   //     maxDate: new Date().fp_incr(1), // Tomorrow's date as the maximum date
   //     disable: [
   //         function(date) {
   //             // Disable all dates before today
   //             return date < new Date();
   //         },
   //         function(date) {
   //             // Disable all dates after tomorrow
   //             const tomorrow = new Date();
   //             tomorrow.setDate(tomorrow.getDate() + 1);
   //             return date > tomorrow;
   //         }
   //     ],
   //     dateFormat: "Y-m-d",
   //     disableMobile: true // To ensure a better experience on mobile devices
   // });



       document.addEventListener("DOMContentLoaded", function () {
           // Initialize Litepicker with date restrictions
           const inputDate = document.getElementById('date');
           const today = new Date();
           const tomorrow = new Date(today);
           tomorrow.setDate(tomorrow.getDate() + 1);

           // Format tanggal menjadi YYYY-MM-DD untuk input date
           const formattedToday = today.toISOString().split('T')[0];
           const formattedTomorrow = tomorrow.toISOString().split('T')[0];

           // Initialize Litepicker
           new Litepicker({
               element: inputDate,
               singleMode: true, // Single date selection
               minDate: formattedToday, // Today's date as the minimum date
               maxDate: formattedTomorrow, // Tomorrow's date as the maximum date
               format: 'YYYY-MM-DD', // Updated Date format to "27/07/2023"
               setup: (picker) => {
                   picker.on('selected', (el) => {
                       toggleTimeFrom();
                   });
               }
           });
           // console.log(picker);
            // Tambahkan event listener "select" ke objek Litepicker untuk memanggil fungsi onDateSelect
           // picker.on('select', () => {
           //     toggleTimeFrom();
           // });

       });

       // document.getElementById('date').addEventListener('change', toggleTimeFrom);
</script>

@endpush
