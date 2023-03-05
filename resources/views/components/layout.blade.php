<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Queueing System Prototype</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite('resources/css/app.css')
</head>
<body>

    <x-navbar/>

    <div class="ml-[120px] flex flex-col min-h-screen bg-background py-5 sm:px-16 text-primary gap-5">
        {{ $slot }}
    </div>
    
</body>
</html>