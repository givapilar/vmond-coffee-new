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
@if (session('message'))
    <div>{{ session('message') }}</div>
@endif

<!-- component -->
<div class="antialiased sans-serif min-h-screen bg-gray-900" style="min-height: 900px">
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
	<style>
		[x-cloak] {
			display: none;
		}

		@media print {
			.no-printme  {
				display: none;
			}
			.printme  {
				display: block;
			}
			body {
				line-height: 1.2;
			}
		}

		@page {
			size: A4 portrait;
			counter-increment: page;
		}

		/* Datepicker */
		.date-input {
			background-color: #fff;
			border-radius: 10px;
			padding: 0.5rem 1rem;
			z-index: 2000;
			margin: 3px 0 0 0;
			border-top: 1px solid #eee;
			box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
				0 4px 6px -2px rgba(0, 0, 0, 0.05);
		}
		.date-input.is-hidden {
			display: none;
		}
		.date-input .pika-title {
			padding: 0.5rem;
			width: 100%;
			text-align: center;
		}
		.date-input .pika-prev,
		.date-input .pika-next {
			margin-top: 0;
			/* margin-top: 0.5rem; */
			padding: 0.2rem 0;
			cursor: pointer;
			color: #4299e1;
			text-transform: uppercase;
			font-size: 0.85rem;
		}
		.date-input .pika-prev:hover,
		.date-input .pika-next:hover {
			text-decoration: underline;
		}
		.date-input .pika-prev {
			float: left;
		}
		.date-input .pika-next {
			float: right;
		}
		.date-input .pika-label {
			display: inline-block;
			font-size: 0;
		}
		.date-input .pika-select-month,
		.date-input .pika-select-year {
			display: inline-block;
			border: 1px solid #ddd;
			color: #444;
			background-color: #fff;
			border-radius: 10px;
			font-size: 0.9rem;
			padding-left: 0.5em;
			padding-right: 0.5em;
			padding-top: 0.25em;
			padding-bottom: 0.25em;
			appearance: none;
		}
		.date-input .pika-select-month:focus,
		.date-input .pika-select-year:focus {
			border-color: #cbd5e0;
			outline: none;
		}
		.date-input .pika-select-month {
			margin-right: 0.25em;
		}
		.date-input table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 0.2rem;
		}
		.date-input table th {
			width: 2em;
			height: 2em;
			font-weight: normal;
			color: #718096;
			text-align: center;
		}
		.date-input table th abbr {
			text-decoration: none;
		}
		.date-input table td {
			padding: 2px;
		}
		.date-input table td button {
			/* border: 1px solid #e2e8f0; */
			width: 1.8em;
			height: 1.8em;
			text-align: center;
			color: #555;
			border-radius: 10px;
		}
		.date-input table td button:hover {
			background-color: #bee3f8;
		}
		.date-input table td.is-today button {
			background-color: #ebf8ff;
		}
		.date-input table td.is-selected button {
			background-color: #3182ce;
		}
		.date-input table td.is-selected button {
			color: white;
		}
		.date-input table td.is-selected button:hover {
			color: white;
		}
	</style>

	<div class="border-t-8 border-gray-700 h-2"></div>
	<div class="container dark:bg-gray-900 mx-auto py-6 px-4" x-data="invoices()" x-init="generateInvoiceNumber(111111, 999999);" x-cloak>
		<div class="flex justify-between">
			<h2 class="text-2xl dark:text-gray-400 font-bold mb-6 pb-2 tracking-wider uppercase">Invoice</h2>
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
                <div class="mb-2 md:mb-1 md:flex items-center">
                    <a href="{{ route('cetak-pdf',Crypt::encryptString($orders->id)) }}">
                        <button class="w-4/12 dark:text-gray-300 bg-red-600 text-xs rounded-lg mt-2 p-1 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-sky-300">PDF<ion-icon name="document" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    </a>
				</div>

			</div>

            <div class="w-2/4" style="text-align: -webkit-right;">
				<div class="mb-2 md:mb-1 md:flex items-center">
					<label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">{{ $orders->name }}</label>
				</div>
				
                <div class="mb-2 md:mb-1 md:flex items-center">
					<label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide">#{{ $orders->invoice_no }}</label>
				</div>

                <div class="mb-2 md:mb-1 md:flex items-center">
					<label class="w-32 text-gray-800 dark:text-gray-400 block font-bold text-sm uppercase tracking-wide"><span class="inline-flex items-center rounded-md bg-green-300 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $orders->status }}</span></label>
				</div>

			</div>
		</div>

		
        
		<div class="flex -mx-1 border-b py-2 items-start">
			<div class="flex-1 px-1">
				<p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">Item</p>
			</div>

			<div class="px-1 w-20 text-right">
				<p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">Price</p>
			</div>

			<div class="px-1 w-32 text-right">
				<p class="leading-none">
					<span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">QTY</span>
				</p>
			</div>

			<div class="px-1 w-32 text-right">
				<p class="leading-none">
					<span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">Total</span>
				</p>
			</div>

			<div class="px-1 w-20 text-center">
			</div>
		</div>
        @foreach ($orders->orderPivot as $order)
		<div class="flex -mx-1 border-b py-2 items-start">
			<div class="flex-1 px-1">
				<p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">{{ $order->restaurant->nama }}</p>
			</div>

			<div class="px-1 w-20 text-right">
				<p class="text-gray-800 dark:text-gray-400 uppercase tracking-wide text-sm font-bold">{{ $order->restaurant->harga }}</p>
			</div>

			<div class="px-1 w-32 text-right">
				<p class="leading-none">
					<span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">{{ $order->qty ?? 0 * $order->restaurant->harga}}  </span>
				</p>
			</div>

			<div class="px-1 w-32 text-right">
				<p class="leading-none">
					<span class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-400">{{ number_format($order->restaurant->harga * $order->order->qty ?? 0 * $order->restaurant->harga , 2) }}</span>
				</p>
			</div>

			<div class="px-1 w-20 text-center">
			</div>
		</div>
        @endforeach

		<div class="py-2 ml-auto mt-5 w-full w-2/4">
			<div class="flex justify-between mb-4">
				<div class="text-sm text-gray-600 dark:text-gray-400 text-right flex-1">PPN 11%</div>
				<div class="text-right w-40">
					<div class="text-sm text-gray-600">{{ number_format($orders->total_price * 11/100,2 )  }}</div>
				</div>
			</div>

			<div class="flex justify-between mb-4">
				<div class="text-sm text-gray-600 dark:text-gray-400 text-right flex-1">Layanan</div>
				<div class="text-right w-40">
					<div class="text-sm text-gray-600" >
                        <?php
                        $biaya_layanan = 5000;
                        ?>
                        {{ number_format($biaya_layanan ?? '0',2) }}
                    </div>
				</div>
			</div>
		
			<div class="py-2 border-t border-b">
				<div class="flex justify-between">
					<div class="text-xl text-gray-600 dark:text-gray-400 text-right flex-1">Total</div>
					<div class="text-right w-40">
						<div class="text-xl text-gray-600">{{ number_format($orders->total_price,2 )  }}</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
	<script>
        window.addEventListener('DOMContentLoaded', function() {
			const today = new Date();
		
            var picker = new Pikaday({
				keyboardInput: false,
				field: document.querySelector('.js-datepicker'),
				format: 'MMM D YYYY',
				theme: 'date-input',
				i18n: {
					previousMonth: "Prev",
					nextMonth: "Next",
					months: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec"
					],
					weekdays: [
						"Sunday",
						"Monday",
						"Tuesday",
						"Wednesday",
						"Thursday",
						"Friday",
						"Saturday"
					],
					weekdaysShort: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
				}
			});
			picker.setDate(new Date());

			var picker2 = new Pikaday({
				keyboardInput: false,
				field: document.querySelector('.js-datepicker-2'),
				format: 'MMM D YYYY',
				theme: 'date-input',
				i18n: {
					previousMonth: "Prev",
					nextMonth: "Next",
					months: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec"
					],
					weekdays: [
						"Sunday",
						"Monday",
						"Tuesday",
						"Wednesday",
						"Thursday",
						"Friday",
						"Saturday"
					],
					weekdaysShort: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
				}
			});
			picker2.setDate(new Date());
		});

		function invoices() {
			return {
				items: [],
				invoiceNumber: 0,
				invoiceDate: '',
				invoiceDueDate: '',

				totalGST: 0,
				netTotal: 0,

				item: {
					id: '',
					name: '',
					qty: 0,
					rate: 0,
					total: 0,
					gst: 18
				},

				billing: {
					name: '',
					address: '',
					extra: ''
				},
				from: {
					name: '',
					address: '',
					extra: ''
				},

				showTooltip: false,
				showTooltip2: false,
				openModal: false,

				addItem() {
					this.items.push({
						id: this.generateUUID(),
						name: this.item.name,
						qty: this.item.qty,
						rate: this.item.rate,
						gst: this.calculateGST(this.item.gst, this.item.rate),
						total: this.item.qty * this.item.rate
					})

					this.itemTotal();
					this.itemTotalGST();

					this.item.id = '';
					this.item.name = '';
					this.item.qty = 0;
					this.item.rate = 0;
					this.item.gst = 18;
					this.item.total = 0;
				},

				deleteItem(uuid) {
					this.items = this.items.filter(item => uuid !== item.id);

					this.itemTotal();
					this.itemTotalGST();
				},

				itemTotal() {
					this.netTotal = this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
						return result + item.total;
					}, 0) : 0);
				},

				itemTotalGST() {
                    this.totalGST =  this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
						return result + (item.gst * item.qty);
					}, 0) : 0);
				},

				calculateGST(GSTPercentage, itemRate) {
					return this.numberFormat((itemRate - (itemRate * (100 / (100 + GSTPercentage)))).toFixed(2));
				},

				generateUUID() {
					return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
						var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
						return v.toString(16);
					});
				},

				generateInvoiceNumber(minimum, maximum) {
					const randomNumber = Math.floor(Math.random() * (maximum - minimum)) + minimum;
					this.invoiceNumber = '#INV-'+ randomNumber;
				},

				numberFormat(amount) {
					return amount.toLocaleString("en-US", {
						style: "currency",
						currency: "INR"
					});
				},

				printInvoice() {
					var printContents = this.$refs.printTemplate.innerHTML;
					var originalContents = document.body.innerHTML;

					document.body.innerHTML = printContents;
					window.print();
					document.body.innerHTML = originalContents;
				}
			}
		}
	</script>

@endsection