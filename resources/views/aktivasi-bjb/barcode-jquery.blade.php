<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Example</title>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- JsBarcode -->
        <script src="https://cdn.jsdelivr.net/jsbarcode/3.11.0/JsBarcode.all.min.js"></script>
    

</head>
<body>
    <svg id="barcode"></svg>

    <script>
        $(document).ready(function () {
            JsBarcode("#barcode", "123456789", {
                format: "CODE128",
                displayValue: true
            });
        });

    </script>
</body>
</html>
