<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <print-component :filename="{{ json_encode($filename) }}"></print-component>
    </div>
</body>
</html>

