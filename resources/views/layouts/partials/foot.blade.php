<script src="{{ asset('js/app.js') }}"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Slick JS -->
   <script src="{{ asset('assetku/dataku/lib/slick-1.8.1/slick/slick.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@stack('script-top')

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

@stack('script-bot')
