<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Es Teh Segar — Point of Sale</title>
    @vite('resources/css/app.css')
</head>

<body>
    <section class="w-full flex flex-col items-center justify-center bg-tea-100">
        <section class="w-full max-w-7xl">
            @yield('content')
        </section>
    </section>
</body>

</html>
