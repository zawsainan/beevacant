<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Positions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white pb-20">
    <div class="px-10">

        <nav class="w-full p-4">
            <a href="/">
                <img src="{{Vite::asset('resources/images/logo.png')}}" class="w-24" alt="Logo" />
            </a>
        </nav>
        <main class="mt-10 max-w-[1200px] mx-auto">
            {{ $slot }}
        </main>
    </div>

</body>

</html>