<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    @vite('resources/js/app.js')
</head>
<body style="background-color: #1B1212;">
    <div id="app">
        <product-component :products="{{ json_encode($data) }}"></product-component>
    </div>
</body>
</html>

