
<!-- Main modal -->
<div id="history-detail-modal{{ $item->code }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <!-- Modal content -->
    <div class="relative bg-gray-700  w-full h-full max-h-full overscroll-x-none overscroll-y-auto">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex gap-2 items-center mt-1">
                <svg class="w-6 h-6 mb-[5px] text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"  aria-hidden="true">
                    <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z"/>
                </svg>
                Detail History Transaction
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="history-detail-modal{{ $item->code }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->

        <div class="p-3 space-y-4 h-full max-h-[77%] overflow-y-scroll">
            <div class="" x-data="invoices()" x-init="generateInvoiceNumber(111111, 999999);" x-cloak>
                <div class="flex justify-center items-center">
                    <h2 class="text-2xl text-gray-400 font-bold mb-6 pb-2 tracking-wider uppercase text-center">Invoice</h2>
                    {{-- <div>
                        <div class="relative inline-block">
                            <div class="text-gray-500 cursor-pointer w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-300 inline-flex items-center justify-center" @mouseenter="showTooltip2 = true" @mouseleave="showTooltip2 = false" @click="window.location.reload()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" />
                                </svg>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="flex mb-8 justify-between">
                    <div class="w-2/4">
                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">Name</label>
                        </div>

                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">Invoice No. </label>
                        </div>

                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">Status</label>
                        </div>
                    </div>

                    <div class="w-2/4" style="text-align: -webkit-right;">
                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">{{ $item->name }}</label>
                        </div>

                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">#{{ $item->invoice_no }}</label>
                        </div>

                        <div class="mb-2 md:mb-1 md:flex items-center">
                            <label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide"><span class="inline-flex items-center rounded-md bg-green-300 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $item->status_pembayaran }}</span></label>
                        </div>

                    </div>
                </div>

                <div class="flex -mx-1 border-b py-2 items-center justify-center">
                    <div class="px-1 w-3/12 text-center">
                        <p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">Item</p>
                    </div>

                    <div class="px-1 w-3/12 text-center">
                        <p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">Price</p>
                    </div>

                    <div class="px-1 w-3/12 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">QTY</span>
                        </p>
                    </div>

                    <div class="px-1 w-3/12 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">Total</span>
                        </p>
                    </div>
                </div>

                @foreach ($item->orderPivot as $order)
                <div class="flex -mx-1 border-b py-2 items-center">
                    <div class="px-1 w-3/12 text-center">
                        <p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">{{ $order->restaurant->nama }}</p>
                    </div>

                    <div class="px-1  w-3/12 text-center">
                        <p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">{{ $order->restaurant->harga }}</p>
                    </div>

                    <div class="px-1  w-3/12 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">{{ $order->qty ?? 1 }}  </span>
                        </p>
                    </div>

                    <div class="px-1  w-3/12 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">{{ $order->restaurant->harga * ($order->qty ?? 1) }}</span>
                        </p>
                    </div>
                </div>
                @endforeach

                <div class="py-2 ml-auto mt-5 w-full w-2/4">
                    <div class="flex justify-between mb-4">
                        <div class="text-sm text-gray-400 text-right flex-1">PPN 11%</div>
                        <div class="text-right w-40">
                            <div class="text-sm text-gray-400">{{ number_format($item->total_price * 11/100,0 )  }}</div>
                        </div>
                    </div>

                    <div class="flex justify-between mb-4">
                        <div class="text-sm text-gray-400 text-right flex-1">Layanan</div>
                        <div class="text-right w-40">
                            <div class="text-sm text-gray-400" >
                                <?php
                                $biaya_layanan = 5000;
                                ?>
                                {{ number_format($biaya_layanan ?? '0',0) }}
                            </div>
                        </div>
                    </div>

                    <div class="py-2 border-t border-b">
                        <div class="flex justify-between">
                            <div class="text-xl text-gray-400 text-right flex-1">Total</div>
                            <div class="text-right w-40">
                                <div class="text-xl text-gray-400">{{ number_format($item->total_price,0 )  }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center w-full">
                        <a href="{{ route('cetak-pdf',Crypt::encryptString($item->id)) }}" class="bg-red-600 text-white text-md rounded-lg mt-2 p-1 w-full text-center hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            <ion-icon name="document" class="text-white"></ion-icon> PDF
                        </a>
                    </div>
                </div>
                <!-- Print Template -->
            </div>
        </div>
    </div>
</div>
