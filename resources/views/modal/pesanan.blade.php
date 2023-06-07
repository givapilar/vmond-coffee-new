
<!-- Main modal -->
<div id="pesanan-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative bg-gray-700  w-full h-full max-h-full overscroll-x-none overscroll-y-auto">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex gap-2 items-center mt-1">
                    <svg class="w-6 h-6 mb-[5px] text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path d="M0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM128 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm32-128a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm96-248c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H448c13.3 0 24-10.7 24-24s-10.7-24-24-24H224z"/>
                    </svg>
                    Pesanan Saya
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="pesanan-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-3">
                @foreach ($order_table as $item)
                @if ($item->status_pembayaran == 'Paid' && $item->status_pesanan != 'selesai')
                <button type="button" class="w-full h-auto" data-modal-target="detail-pesanan-modal{{ $item->id }}" data-modal-toggle="detail-pesanan-modal{{ $item->id }}">
                    <div class="flex items-center bg-gray-600 rounded-lg p-2 border border-gray-500 hover:brightness-75 mt-3">
                        <div class="relative inline-block shrink-0">
                            <img class="w-14 h-14 rounded-full" src="{{ asset('assetku/dataku/img/history-notification.jpg') }}" alt="History Notif"/>
                        </div>
                        <div class="grow ml-3 text-sm font-normal text-start">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">#Ord{{ $item->invoice_no }}</div>
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-500">Pesanan 1</span>
                        </div>
                        <div class="shrink-0">
                            <img class="w-10 h-10 rounded-full p-2" src="{{ asset('assetku/dataku/img/right-arrow.png') }}" alt="History Notif"/>
                        </div>
                    </div>
                </button>
                @include('modal.pesanan-detail')
                @endif
                @endforeach
            </div>
            
    </div>
</div>
