@extends('layouts.app')

@push('style-top')
@endpush
@push('style-bot')
@endpush

@section('content')
<form action="{{ route('checkout-billiard-openbill',md5(strtotime("now"))) }}" method="POST">
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
                        <img src="{{ 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="pt-2 pb-5 w-full">
                    <div class="px-5 mb-2">
                        <p aria-hidden="true" class="text-lg font-semibold dark:text-gray-300">Open Bill</p>
                        <span class="block text-[15px] dark:text-red-500">Rp.-</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-3">
        <div class="text-left h-72 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Informasi Meja Billiard</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <div>
                <img src="{{ asset('assetku/dataku/img/logo/layout.png') }}" alt="">
            </div>
        </div>
    </section>

    <section class="p-3 grid grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-2 mb-2">
        <div class="mt-2 max-w-sm bg-white border border-gray-200 rounded-[30px] shadow px-3 overflow-y-auto dark:bg-gray-800 dark:border-gray-700" style="height: 18rem;">
            <div class="p-3">
                <p class="text-lg font-semibold text-center dark:text-white">Schedule & Table</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                <div class="mt-3">
                    <label for="billiard_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Meja Biliard</label>
                    <select id="billiard_id" required name="billiard_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Pilih Meja Biliard</option>
                        @foreach ($billiard as $biliards)
                            <option value="{{ $biliards->id }}">{{ $biliards->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <label for="date" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>
                    <input type="text" id="date" required name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ date('Y-m-d') }}">
                </div>
                <div class="mt-4" id="timeFromContainer" style="display: none;">
                    <label for="time_from_weekdays" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_weekdays" required name="time_from" class="time_from bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled>Select Time From</option>
                        @for ($time = strtotime('07:00'); $time <= strtotime('22:00'); $time = strtotime('+15 minutes', $time))
                            <option value="{{ date('H:i', $time) }}" {{ old('time_from') == date('H:i', $time) ? 'selected' : '' }}>{{ date('H:i', $time) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mt-4" id="weekend" style="display: none;">
                    <label for="time_from_weekend" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_weekend" required name="time_from" class="time_from bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Select Time From</option>
                        @for ($time = strtotime('07:00'); $time <= strtotime('23:00'); $time = strtotime('+15 minutes', $time))
                            <option value="{{ date('H:i', $time) }}">{{ date('H:i', $time) }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="text-left max-w-sm mt-2 h-72 bg-white border border-gray-200 rounded-[30px] shadow overflow-y-auto dark:bg-gray-800 dark:border-gray-700">
            <div class="p-2 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">Informasi Order</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700 px-3">
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Massukan Nama</p>
                        </div>
                    </div>
                    <input placeholder="Massukan Nama" required name="nama_customer" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </li>
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Massukan No Tlp</p>
                        </div>
                    </div>
                    <input placeholder="Massukan No Tlp" required name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </li>
            </ul>
        </div>
    </section>

    <section class="p-3" style="text-align: -webkit-center;">
        <div class="text-left bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
            <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
        </div>
    </section>
</form>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')
@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
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
            //    console.log(data);
               // Enable all options before disabling the appropriate ones
               $("#time_from_weekdays option").prop('disabled', false);
               $("#time_from_weekend option").prop('disabled', false);
               disableByCurrentTimeWith15MinuteInterval()
               // Get the current time
               const currentTime = new Date();
               const currentHour = currentTime.getHours();

               for (const index in data.timeFrom) {
                   const dateFrom = data.timeFrom[index];
                //    console.log(dateFrom);
                   const dateTo = data.timeTo[index];
                   let valHourFrom = dateFrom.substring(0, 5);
                   let valHourTo = dateTo.substring(0, 5);
                   const hourPart = parseInt(valHourFrom.substring(0, 2), 10);

                   // Loop through options and disable past hours and the current hour for weekdays
                    // ubah manual
                   const timeFromWeekdaysSelect = $("#time_from_weekend");
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
                            //    console.log('From',fromHour);

                               // Check if the current option time is within the dateFrom and dateTo range
                               if (
                                   (elemHour === fromHour && elemMinute >= fromMinute) ||
                                   (elemHour === toHour && elemMinute <= toMinute) ||
                                   (elemHour > fromHour && elemHour < toHour)
                               ) {
                                   console.log(fromHour, fromMinute, fromMinute, toMinute, elem);
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

{{-- Get The Detail Add On --}}
<script>
    function getAddOn(id, no) {
        console.log('masuk');
        $('.add-ons-list-' + no).css('display', 'none');
        $('#add-ons-' + id).css('display', 'block');
        // Remove All selected add on
        $('.typeAddOn'+no).prop('checked', false);
        $('.detail-add-ons-'+no).css('display', 'none');
        $('.detail-add-ons-input-'+no).prop('checked', false);
    }
    function getAddOnDetail(id, type)
    {
        if (type === 'normal') {
            $('#detail-add-ons-'+id).css('display', 'block');
        }
        // else {
        //     $('#detail-add-ons-'+id).css('display', 'none');
        // }
    }
</script>
@endpush
