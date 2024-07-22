@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')

<form action="{{ route('checkout-billiard-guest', md5(strtotime('now'))) }}" method="POST">
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
                            <p aria-hidden="true" class="text-md font-semibold dark:text-gray-300 text-center">Pilihan Makanan Dan Minuman</p>
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
                                                    {{-- Inputan Makanan/Minuman --}}
                                                    <input id="choice-menu-{{ $restaurant->nama }}-{{ $i }}" onclick="getAddOn('{{ $restaurant->id . '-' . $i }}', '{{ $i }}')" type="radio" value="{{ $restaurant->id }}" name="paket_restaurant_id[{{ $groupIdentifier }}]" class="restaurant-input w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom"/>
                                                </div>
                                                <label for="choice-menu-{{ $restaurant->nama }}-{{ $i }}" class="ml-3">
                                                    <span id="choice-menu-{{ $restaurant->nama }}-{{ $i }}-description" class="text-sm text-white dark:text-white">
                                                        {{ $restaurant->nama ?? '' }}
                                                    </span>
                                                    <br />
                                                </label>
                                            </div>
                                            <div class="w-full">
                                                @php
                                                    $min = 0;
                                                @endphp
                                                <div id="add-ons-{{ $restaurant->id . '-' . $i }}" style="display: none;" class="add-ons-list-{{ $i }} divide-y divide-gray-200 dark:divide-gray-700">
                                                    @if ($restaurant->addOns->count() > 0)
                                                        <ul>
                                                            <li class="py-3 sm:py-2">
                                                                <div class="flex items-center space-x-4 px-3">
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">1. Add On</p>
                                                                    </div>
                                                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                        <input id="normal-radio" type="radio" onchange="getAddOnDetail('{{ $restaurant->id . '-' . $i }}', 'normal')" value="Normal" name="addOnChange{{ $restaurant->id }}" class="typeAddOn{{ $i }} w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                    <div class="grid grid-cols-3 detail-add-ons-{{ $i }}" id="detail-add-ons-{{ $restaurant->id . '-' . $i }}" style="margin: 10px 30px; display:none;">
                                                        @foreach ($add_ons as $add_on)
                                                            @foreach ($restaurant->addOns as $key => $resto)
                                                                @if ($resto->add_on_id == $add_on->id)
                                                                <div class="w-full" id="{{ str_replace(' ', '', strtolower($add_on->title)) }}">
                                                                    <input style="display: none;" type="hidden" class="custom add-ons-title" name="add_on_title[]" value="{{ $add_on->title }}" id="">
                                                                    <div class="flex justify-center align-center py-2 px-3">
                                                                        <p aria-hidden="true" class="text-sm font-semibold dark:text-white text-center break-words">{{ $add_on->title . '(Pilih '. $add_on->minimum_choice .')' ?? 'Error' }}</p>
                                                                    </div>
                                                                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                                                    @foreach ($add_on->detailAddOn as $item)
                                                                        <div class="relative flex items-center px-3" id="detail-{{ $item->id }}">
                                                                            <div class="flex items-center h-5">
                                                                                <input id="{{ str_replace(' ', '', strtolower($item->nama)) }}-{{ $item->id }}" type="radio" value="{{ $item->id }}" name="harga_add{{ $groupIdentifier }}[{{ $groupIdentifier . '-' . $add_on->id }}]" class="detail-add-ons-input-{{ $i }} w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom {{ substr(strtolower($item->nama), 0, 6) }}">
                                                                            </div>
                                                                            <label for="{{ str_replace(' ', '', strtolower($item->nama)) }}-{{ $item->id }}" class="ml-3">
                                                                                <span id="{{ str_replace(' ', '', strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">{{ $item->nama ?? '' }}</span> <br>
                                                                                <span id="{{ str_replace(' ', '', strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">Rp. {{ $item->harga ?? '' }}</span>
                                                                            </label>
                                                                        </div>
                                                                        @if (!$loop->last)
                                                                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>
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
                </div>
                <div class="mt-4" id="timeFromContainer" style="display: none;">
                    <label for="countries" class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Time From</label>
                    <select id="time_from_weekdays" required name="time_from" class="time_from bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option disabled selected>Select Time From</option>
                        <?php
                        $startTime = strtotime('09:00');
                        $endTime = strtotime('22:00');
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
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Massukan Nama</p>
                        </div>
                    </div>
                    <input placeholder="Massukan Nama" required name="nama_user" id="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama_user') is-invalid @enderror">
                </li>
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Massukan No Tlp</p>
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
                            <p class="text-xs font-normal text-gray-900 truncate dark:text-white">Sub Total</p>
                        </div>
                        <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                            Rp. {{ number_format($paket_menu->harga_diskon ?? 0, 0) }}
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-3">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-normal text-gray-900 truncate dark:text-white">Service</p>
                        </div>
                        <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                            <?php
                            $biaya_layanan = number_format(($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan / 100, 0);
                            ?>
                            Rp. {{ $biaya_layanan }}
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-3">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-normal text-gray-900 truncate dark:text-white">PB01 10%</p>
                        </div>
                        <div class="inline-flex items-center text-xs font-normal text-gray-900 dark:text-white">
                            <?php
                            $biaya_pb01 = number_format((($paket_menu->harga_diskon ?? '0') + ($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan / 100) * $order_settings[0]->pb01 / 100, 0);
                            ?>
                            Rp. {{ $biaya_pb01 }}
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-3">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-900 truncate dark:text-white">Order Total</p>
                        </div>
                        <div class="inline-flex items-center text-xs font-medium text-gray-900 dark:text-white">
                            @if ($paket_menu->harga_diskon)
                            Rp. {{ number_format(($paket_menu->harga_diskon + (($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan / 100)) + (($paket_menu->harga_diskon ?? '0') + ($paket_menu->harga_diskon ?? '0') * $order_settings[0]->layanan / 100) * $order_settings[0]->pb01 / 100, 0) }}
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
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

<script>
    function pad(number) {
        return (number < 10) ? '0' + number : number;
    }

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

    function getAddOn(id, no) {
        console.log('masuk');
        $('.add-ons-list-' + no).css('display', 'none');
        $('#add-ons-' + id).css('display', 'block');
    }
    function getAddOnDetail(id, type)
    {
        if (type === 'normal') {
            $('#detail-add-ons-'+id).css('display', 'block');
        }
    }
</script>

@endpush
