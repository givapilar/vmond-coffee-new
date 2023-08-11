<script src="{{ asset('js/app.js') }}"></script>
<!-- JQuery -->
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
<!-- Slick JS -->
<script src="{{ asset('assetku/dataku/lib/slick-1.8.1/slick/slick.min.js') }}"></script>
{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>--}}
<script src="{{ asset('assetku/dataku/lib/swiper/swiper-element-bundle.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
@stack('script-top')
 
<!-- from cdn -->
<script src="https://unpkg.com/@material-tailwind/html@latest/scripts/tabs.js"></script>

<script>
    document.documentElement.classList.add('dark');

    // function signout(url) {
    //     $.confirm({
    //         icon: 'fas fa-sign-out-alt',
    //         title: 'Logout',
    //         theme: 'supervan',
    //         content: 'Are you sure want to logout?',
    //         autoClose: 'cancel|8000',
    //         buttons: {
    //             logout: {
    //                 text: 'logout',
    //                 action: function () {
    //                     $.ajax({
    //                         type: 'POST',
    //                         url: '/logout',
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                         data: {
    //                             "_token": "{{ csrf_token() }}"
    //                         },
    //                         success: function (data) {
    //                             // location.reload();
    //                             window.location.href(url)
    //                         },
    //                         error: function (data) {
    //                             $.alert('Failed!');
    //                             console.log(data);
    //                         }
    //                     });
    //                 }
    //             },
    //             cancel: function () {

    //             }
    //         }
    //     });
    //     // $.confirm({
    //     //     title: 'Logout?',
    //     //     content: 'Your time is out, you will be automatically logged out in 10 seconds.',
    //     //     autoClose: 'logoutUser|10000',
    //     //     buttons: {
    //     //         logoutUser: {
    //     //             text: 'logout myself',
    //     //             action: function () {
    //     //                 $.ajax({
    //     //                     type: 'POST',
    //     //                     url: '/logout',
    //     //                     headers: {
    //     //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     //                     },
    //     //                     data: {
    //     //                         "_token": "{{ csrf_token() }}"
    //     //                     },
    //     //                     success: function (data) {
    //     //                         // location.reload();
    //     //                         window.location.href(url)
    //     //                     },
    //     //                     error: function (data) {
    //     //                         $.alert('Failed!');
    //     //                     }
    //     //                 });
    //     //             }
    //     //         },
    //     //         cancel: function () {

    //     //         }
    //     //     }
    //     // });
    // }
</script>
<script>
    function phoneMask() {
        var num = $(this).val().replace(/\D/g,'');
        $(this).val(num.substring(0,13));
    }
    $('[type="tel"]').keyup(phoneMask);
</script>

{{-- @if(session('message'))
<script>
    Toastify({
        text: '{{ session('message') }}',
        close: true,
        gravity: 'top', // `top` or `bottom`
        position: 'right', // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: '#D5F3E9',
            color: '#1f7556'
        },
        duration: 3000
    }).showToast();
</script>
@endif --}}

<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="{{ asset('assetku/dataku/lib/alpine/alpine.js') }}" defer></script>
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
{{-- @endif --}}

@if(session()->has('success'))
    <script>
            Toastify({
                text: "{{ session()->get('success') }}",
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "left", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#D5F3E9",
                    color: "#1f7556"
                },
                duration: 1000
            }).showToast();
    </script>
@endif

@if(session()->has('warning'))
<script>
        Toastify({
            text: "{{ session()->get('warning') }}",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "left", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "#FBEFDB",
                color: "#916c2e"
            },
            duration: 1000
        }).showToast();
</script>
@endif

@if(session()->has('failed'))
<script>
    Toastify({
        text: "🚨 {{ session()->get('failed') }}",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        theme: "dark",
        style: {
            background: "#fde1e1",
            color: "#924040"
        },
        duration: 5000
    }).showToast();
</script>
@endif
@stack('script-bot')
