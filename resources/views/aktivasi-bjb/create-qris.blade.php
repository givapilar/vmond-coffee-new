{{-- <div class="card-body">
    <div class="form-group mb-3">
        <label for="msisdn">Msisdn</label>
        <input type="text" value="" class="form-control" name="msisdn" id="msisdn" placeholder="Input Msisdn...">
    </div>
    <div class="form-group mb-3">
        <label for="amount">Amount</label>
        <input type="text" value="" class="form-control" name="amount" id="amount" placeholder="Input amount...">
    </div>

    <div class="form-group mb-3">
        <label for="exp_in_second">Exp</label>
        <input type="text" value="" class="form-control" name="exp_in_second" id="exp_in_second" placeholder="Input exp_in_second...">
    </div>
</div>
 --}}

 <div class="card-body">
    <div class="form-group mb-3">
        <label for="msisdn">Qr 1</label>
        {{-- <img src="{{ $qrcodeUrl }}" alt="QR Code"> --}}
        {!! $qrCode !!}
    </div>
</div>

