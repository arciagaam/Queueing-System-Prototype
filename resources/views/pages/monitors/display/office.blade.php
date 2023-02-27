<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $calls[0]->name }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex flex-row leading-none h-screen">

        <div class="flex flex-col min-w-[35%]">

            <div class="flex flex-col flex-1">

                <div class=" grid grid-cols-2 bg-primary text-white font-bold">
                    <div class="text-lg flex items-center justify-center">QUEUE NUMBER</div>
                    <div class="text-lg flex items-center justify-center">WINDOW</div>
                </div>
                
                @foreach ($calls as $index => $call)
                    <div class="h-[20%] inline-grid grid-cols-2 ">
                        <div class="text-8xl flex items-center justify-center px-5 font-bold text-white {{ $index % 2 == 0 ? 'bg-secondary' : 'bg-[#0FAC7B]' }}">{{ $call->code }}</div>
                        <div class="text-8xl flex items-center justify-center px-5 font-bold text-primary  {{ $index % 2 == 0 ? 'bg-white' : 'bg-[#E1E1E1]' }}">{{ $call->number }}</div>
                    </div>
                @endforeach
                

                

            </div>
        </div>

        <div class="flex flex-col flex-1">

            <div class="flex flex-row flex-1 bg-primary text-white items-center justify-between px-5">
                <img src="/images/logo.png" class="h-[75px]" alt="">
                <p class="font-bold text-lg">{{ $calls[0]->name }}</p>
                <p>MYR</p>
            </div>

            <div style="background-image: url(/images/window-image.png)" class="flex flex-[4] bg-cover bg-center after:inset-0 after:bg-black after:z-10 after:h-full">
            </div>

        </div>

    </div>
</body>

</html>
