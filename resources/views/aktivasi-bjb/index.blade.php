<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktivasi</title>
</head>
<body>
    <button onclick="">Test</button>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script>
    function test() {
        axios.get("http://172.31.32.85/v1/api/").then(function (response) {
            console.log(response)
            // do whatever you want if console is [object object] then stringify the response
        })
    }
</script>
</html>