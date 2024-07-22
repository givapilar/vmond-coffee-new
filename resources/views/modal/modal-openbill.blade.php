<!-- Main modal -->
<div id="modal-openbill-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative bg-gray-700  w-full h-full max-h-full overscroll-x-none overscroll-y-auto">
        <form action="{{ route('checkout-billiard-openbill-update', $item->id ) }}" method="POST">
        @csrf

        <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex gap-2 items-center mt-1">
                    <svg class="w-6 h-6 mb-[5px] text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path d="M0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM128 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm32-128a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm96-248c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224z"/>
                    </svg>
                    Payment
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-openbill-{{ $item->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700 px-3">
                {{-- <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/edc.png') }}" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Payment Gateaway Online</p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <input required type="radio" id="payment_gateaway" value="Payment Gateaway Online" name="tipe_pemesanan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>
                </li> --}}
                <li class="py-3 sm:py-2">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/pos.png') }}" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">EDC</p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <input required type="radio" class="edisi-radio w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-2 edisi-pembayaran-wrapper" style="display:none;">
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

            <div class="fixed bottom-0 w-full h-auto">
                <div class="flex items-center px-6 py-4 space-x-2 border-t border-gray-200 dark:border-gray-600">
                    <button type="submit" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('assetku/dataku/js/socket.io.js') }}"></script> --}}
<script>
    // const paymentGatewayRadio = document.getElementById('payment_gateaway');
    const edcRadio = document.querySelector('.edisi-radio');
    const edisiPembayaranWrapper = document.querySelector('.edisi-pembayaran-wrapper');

    edcRadio.addEventListener('change', function() {
        if (this.checked) {
            edisiPembayaranWrapper.style.display = 'block';
        } else {
            edisiPembayaranWrapper.style.display = 'none';
        }
    });

</script>
