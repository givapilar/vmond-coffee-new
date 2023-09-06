<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktivasi</title>
</head>
<body>
    <button onclick="test()">Test</button>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    let token = '';
    function test() {
        axios.post("https://vmondcoffee.controlindo.com/aktivasi-bjb").then(function (response) {
            console.log(response.data.token)
            // do whatever you want if console is [object object] then stringify the response
        })
    }
    // function addTag(id) {
    //         $.confirm({
    //             title: 'Send OTP',
    //             content: "URL:{{ route('send-otp') }}",
    //             columnClass: 'medium',
    //             type: 'blue',
    //             typeAnimated: true,
    //             buttons: {
    //                 formSubmit: {
    //                     text: 'Submit',
    //                     btnClass: 'btn-blue',
    //                     action: function() {
    //                         let no_telp, tag_type_data, tag_address, tag_formula, tag_point, tag_formula_adjust, tag_point_adjust;
    //                         no_telp = this.$content.find('#no_telp').val();
    //                         tag_type_data = this.$content.find('#tag_type_data').val();
    //                         tag_address = this.$content.find('#tag_address').val();
    //                         tag_formula = this.$content.find('#tag_formula').val();
    //                         tag_point = this.$content.find('#tag_point').val();
    //                         tag_formula_adjust = this.$content.find('#tag_formula_adjust').val();
    //                         tag_point_adjust = this.$content.find('#tag_point_adjust').val();

    //                         $.ajax({
    //                             type: 'POST',
    //                             url: "{{ route('tag-store-data') }}",
    //                             headers: {
    //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                             },
    //                             data: {
    //                                 "_token": "{{ csrf_token() }}",
    //                                 controllerId,
    //                                 tag_name,
    //                                 tag_type_data,
    //                                 tag_address,
    //                                 tag_formula,
    //                                 tag_point,
    //                                 tag_formula_adjust,
    //                                 tag_point_adjust
    //                             },
    //                             async: false,
    //                             success: function(data) {
    //                                 console.log(data);
    //                                 Swal.fire(
    //                                     'Successfully!',
    //                                     'Tag added successfully!',
    //                                     'success'
    //                                 ).then((result) => {
    //                                     /* Read more about isConfirmed, isDenied below */
    //                                     if (result.isConfirmed) {
    //                                         location.reload();
    //                                     } else {
    //                                         location.reload();
    //                                     }
    //                                 });
    //                             },
    //                             error: function(data) {
    //                                 console.log(data);
    //                                 $.alert(data.responseJSON.message);
    //                             }
    //                         });
    //                     }
    //                 },
    //                 cancel: function() {
    //                     //close
    //                 },
    //             },
    //             onContentReady: function() {
    //                 // bind to events
    //                 var jc = this;
    //                 this.$content.find('form').on('submit', function(e) {
    //                     // if the user submits the form by pressing enter in the field.
    //                     e.preventDefault();
    //                     jc.$$formSubmit.trigger('click'); // reference the button and click it
    //                 });
    //             }
    //         });
    //     }
</script>
</html>