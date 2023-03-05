<script>
    const office_id = '{{ $office->id }}';
    const monitor_id = '{{ $monitor->id }}';
    const contentCount = '{{count($contents)}}';
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $office->name }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/monitor.js')

</head>

<body>

    <div class="flex flex-row leading-none h-screen gap-1 bg-primary">

        <div class="flex flex-col min-w-[35%] flex-1 bg-white">

            <div class="flex flex-col flex-1">

                <div class=" grid grid-cols-2 bg-primary text-white font-bold">
                    <div class="text-lg flex items-center justify-center">QUEUE NUMBER</div>
                    <div class="text-lg flex items-center justify-center">WINDOW</div>
                </div>

                <div id="queue-container" class="flex flex-col flex-1 w-full">
                    @if(count($calls) > 0)
                        @foreach ($calls as $index => $call)
                            <div class="h-[20%] inline-grid grid-cols-2 ">
                                <div class="text-8xl flex items-center justify-center px-5 font-bold text-white {{ $index % 2 == 0 ? 'bg-secondary' : 'bg-[#0FAC7B]' }}">
                                    {{ $call->code }}
                                </div>
                                
                                    
                                    @if ($call->use_name == 1)
                                        <div class="text-4xl flex items-center justify-center px-5 font-bold text-primary  {{ $index % 2 == 0 ? 'bg-white' : 'bg-[#E1E1E1]' }}">
                                            {{ $call->window_name }}
                                        </div>
                                    @else
                                    <div class="text-8xl flex items-center justify-center px-5 font-bold text-primary  {{ $index % 2 == 0 ? 'bg-white' : 'bg-[#E1E1E1]' }}">
                                        {{ $call->number }}
                                    </div>
                                    @endif
                            </div>
                        @endforeach
                    @else
                        <div class="h-[20%] inline-grid grid-cols-1 w-full">
                            <div class="text-4xl flex items-center justify-center px-5 font-bold text-primary bg-[#E1E1E1]">
                                No queue
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="flex flex-col w-1/2 bg-primary gap-1">

            <div class="relative bg-[#1e1e1e] text-white min-h-[200px]">
                <div class="absolute inset-0 grid grid-cols-3 text-center place-items-center z-10">                    
                    <img src="/images/logo.png" class="h-[100px]" alt="">
                    <p class="font-bold text-5xl">{{ $office->name }}</p>
                    <div style="background-image: url(/images/mayor.png)" class="h-full w-full bg-contain bg-center bg-no-repeat"></div>
                </div>

                <div style="background-image: url(/images/cityhall.jfif)" class="h-full w-full bg-cover bg-no-repeat bg-center opacity-25 z-0"></div>
            </div>

            <div class="relative flex flex-[4] bg-cover bg-center after:inset-0 after:bg-black after:z-10 after:h-full">
                @foreach ($contents as $index => $content)
                    @if ($content->type == 0)
                        <img data-index='{{$index}}' class="hidden absolute w-full h-full object-cover object-center z-[{{$index}}]" src="/images/{{$monitor->id}}/{{$content->file}}" alt="image">
                    @else
                        <video data-index='{{$index}}' class="hidden absolute w-full h-full object-cover object-center z-[{{$index}}]" src="/videos/{{$monitor->id}}/{{$content->file}}" autoplay muted></video>

                    @endif
                @endforeach
            </div>

        </div>

    </div>
</body>

</html>
