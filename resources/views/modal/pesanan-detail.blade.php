<!-- Main modal -->
<div id="detail-pesanan-modal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative bg-gray-700  w-full h-full max-h-full overscroll-x-none overscroll-y-auto">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex gap-2 items-center mt-1">
                    <svg class="w-6 h-6 mb-[5px] text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path d="M0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM128 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm32-128a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm96-248c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224z"/>
                    </svg>
                    Detail Pesanan Saya
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-pesanan-modal{{ $item->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-2">
                <div class="max-w-xl mx-auto mt-4 mb-2 py-4 border-2 border-gray-300 border-dashed">
                    <div class="border-b-2 border-dashed border-gray-300 text-center pb-3">
                        <span class="text-lg text-gray-200">Progress Pesanan Saya</span>
                    </div>
                    <div class="flex py-4 px-3 justify-center gap-3">
                        <div class="">
                            <div class="w-10 h-10 bg-green-400 mx-auto rounded-full text-lg text-white flex items-center">
                                <span class="text-white text-center w-full">
                                    <svg class="w-5 h-5 text-white block mx-auto" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                </span>
                            </div>
                        </div>


                        <div class="w-1/5 align-center items-center align-middle content-center flex">
                            <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                                 <div class="bg-green-300 text-xs leading-none py-1 text-center text-grey-darkest rounded " style="width: 100%"></div>
                            </div>
                        </div>


                        @if ($item->status_pesanan == 'selesai')

                        <div class="">
                            <div class="w-10 h-10 bg-green-400 mx-auto rounded-full text-lg text-white flex items-center">
                                <svg class="w-5 h-5 text-gray-500 block mx-auto" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                        </div>
                        @else
                        <div class="">
                            <div class="w-10 h-10 bg-white border-2 border-grey-light mx-auto rounded-full text-md text-white flex items-center">
                                <svg class="w-5 h-5 text-gray-500 block mx-auto" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM288 437v11H96V437c0-25.5 10.1-49.9 28.1-67.9L192 301.3l67.9 67.9c18 18 28.1 42.4 28.1 67.9z"/></svg>
                            </div>
                        </div>
                        @endif

                        {{-- Selesai --}}

                        @if ($item->status_pesanan == 'selesai')
                        <div class="w-1/5 align-center items-center align-middle content-center flex">
                            <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                                 <div class="bg-green-300 text-xs leading-none py-1 text-center text-grey-darkest rounded " style="width: 100%"></div>
                            </div>
                        </div>
                        @else
                        <div class="w-1/5 align-center items-center align-middle content-center flex">
                            <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                                 <div class="bg-green-300 text-xs leading-none py-1 text-center text-grey-darkest rounded " style="width: 0%"></div>
                            </div>
                        </div>
                        @endif


                        @if ($item->status_pesanan == 'selesai')

                        <div class="">
                            <div class="w-10 h-10 bg-green-400 mx-auto rounded-full text-lg text-white flex items-center">
                                <svg class="w-5 h-5 text-gray-500 block mx-auto" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/></svg>
                            </div>
                        </div>
                        @else
                        <div class="">
                            <div class="w-10 h-10 bg-white border-2 border-grey-light mx-auto rounded-full text-md text-white flex items-center">
                                <svg class="w-5 h-5 text-gray-500 block mx-auto" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/></svg>
                            </div>
                        </div>

                        @endif
                    </div>

                    <div class="flex text-xs content-center text-center">
                        <div class="w-2/4 text-white">
                            Konfirmasi
                        </div>

                        <div class="w-2/4 text-white">
                            Dalam proses
                        </div>

                        <div class="w-2/4 text-white">
                            Selesai
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="">{{ $item }}</div> --}}
            <div class="p-2">
                <div class="max-w-xl mx-auto my-4 border border-gray-300">
                    @foreach ($item->orderPivot as $order)
                    <div class="flex items-center border-b border-gray-300 p-3">
                        <div class="grow ml-3 text-sm font-normal">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->restaurant->nama ?? $order->paketMenu->nama_paket }}</div>
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-500">a few seconds ago</span>
                        </div>
                    </div>
                    @endforeach

                    @if ($item->biliard_id != null)
                        <div class="flex items-center border-b border-gray-300 p-3">
                            <div class="grow ml-3 text-sm font-normal">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">Status Lamp</div>
                                @if ($item->status_lamp == 'ON')
                                <span class="text-xs font-medium text-green-600 dark:text-green-500" style="color: #37fa2d;">On</span>
                                @else
                                <span class="text-xs font-medium text-green-600 dark:text-green-500" style="color: #fa2d2d;">Off</span>
                                @endif
                            </div>
                        </div>
                        @foreach ($item->orderBilliard as $order_billiard)

                        <div class="flex items-center border-b border-gray-300 p-3">
                            <div class="grow ml-3 text-sm font-normal">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order_billiard->restaurant->nama ?? $order_billiard->paketMenu->nama_paket }}</div>
                                <span class="text-xs font-medium text-blue-600 dark:text-blue-500">a few seconds ago</span>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            @if ($item->status_pembayaran == 'Unpaid' && $item->invoice_no != 'draft' && $item->biliard_id != null &&  $item->time_to == null && $item->tipe_pemesanan == 'OpenBill')
            <!-- Modal footer -->
            <div class="fixed bottom-0 w-full h-auto">
                <div class="flex items-center px-6 py-4 space-x-2 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-toggle="modal-openbill-{{ $item->id }}">Close Bill</button>
                </div>
            </div>
            @endif
            @include('modal.modal-openbill')
    </div>
</div>
