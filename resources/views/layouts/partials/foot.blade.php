
<script src="{{ asset('js/app.js') }}"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Slick JS -->
   <script src="{{ asset('assetku/dataku/lib/slick-1.8.1/slick/slick.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

@stack('script-top')

<script>
    document.documentElement.classList.add('dark');
</script>

@stack('script-bot')
