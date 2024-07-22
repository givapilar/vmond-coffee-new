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
                        <option disabled selected>Select Time From</option>
                        @for ($time = strtotime('07:00'); $time <= strtotime('22:00'); $time = strtotime('+15 minutes', $time))
                            <option value="{{ date('H:i', $time) }}">{{ date('H:i', $time) }}</option>
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
    function disableByCurrentTimeWith15MinuteInterval() {
        const timeFromSelect = $('#time_from_weekdays, #time_from_weekend');
        const currentTime = new Date();
        const currentHour = currentTime.getHours();
        const currentMinute = currentTime.getMinutes();
        const nearestInterval = Math.ceil(currentMinute / 15) * 15 % 60;

        timeFromSelect.find('option').each(function() {
            const [elHour, elMinute] = $(this).val().split(':').map(Number);
            if ((elHour < currentHour) || (elHour === currentHour && elMinute < nearestInterval)) {
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).removeAttr('disabled');
            }
        });
    }

    function disableHour() {
        const valueDate = $('#date').val();
        const billiardId = $('#billiard_id').val();
        console.log(valueDate, billiardId);
        $.ajax({
            type: 'POST',
            url: "{{ route('check-schedule') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: "{{ csrf_token() }}",
                date: valueDate,
                billiard_id: billiardId
            },
            success: function(data) {
                const timeFromSelect = $('#time_from_weekdays, #time_from_weekend');
                timeFromSelect.find('option').prop('disabled', false); // Enable all options first
                disableByCurrentTimeWith15MinuteInterval();
                console.log(data);

                // Disable already booked time slots
                let disableAll = false;
                data.timeFrom.forEach((dateFrom, index) => {
                    const dateTo = data.timeTo[index];
                    const fromHour = parseInt(dateFrom.split(':')[0]);
                    const fromMinute = parseInt(dateFrom.split(':')[1]);

                    if (!dateTo) { // If dateTo is empty
                        disableAll = true;
                    } else {
                        const toHour = parseInt(dateTo.split(':')[0]);
                        const toMinute = parseInt(dateTo.split(':')[1]);

                        timeFromSelect.find('option').each(function() {
                            const [elHour, elMinute] = $(this).val().split(':').map(Number);
                            if ((elHour > fromHour && elHour < toHour) ||
                                (elHour === fromHour && elMinute >= fromMinute) ||
                                (elHour === toHour && elMinute <= toMinute)) {
                                $(this).attr('disabled', 'disabled');
                            }
                        });
                    }
                });

                if (disableAll) {
                    timeFromSelect.find('option').each(function() {
                        $(this).attr('disabled', 'disabled');
                    });
                }
            }
        });
    }

    $('#date').on('change', function() {
        toggleTimeFrom();
        disableHour();
    });

    $('#billiard_id').on('change', disableHour);

    function toggleTimeFrom() {
        const dayOfWeek = new Date($('#date').val()).getDay();
        const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
        $('#timeFromContainer').toggle(!isWeekend);
        $('#weekend').toggle(isWeekend);
    }

    // Initialize Litepicker
    const picker = new Litepicker({
        element: document.getElementById('date'),
        singleMode: true,
        minDate: new Date().toISOString().split('T')[0],
        maxDate: new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().split('T')[0],
        format: 'YYYY-MM-DD',
        setup: (picker) => {
            picker.on('selected', function() {
                toggleTimeFrom();
                disableHour();
            });
        }
    });

    // Initial call to toggleTimeFrom to set the correct display state on page load
    $(document).ready(function() {
        toggleTimeFrom();
        disableHour();
    });

</script>
@endpush
