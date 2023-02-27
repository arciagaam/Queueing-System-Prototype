<script>
    const officeId = {{$office->id}};
    const windowId = {{$window->id}};
</script>

@vite('resources/js/app.js')
@vite('resources/js/script.js')

<x-layout>
        {{-- Breadcrumbs --}}
        <div class="flex flex-row gap-2 items-center">
            <p class="font-regular text-lg">Manage Offices</p>
            <p>></p>
            <p class="font-regular text-lg">{{$office->name}}</p>
            <p>></p>
            <p class="font-bold text-lg">Window {{$window->number}}</p>
        </div>

        <div class="flex flex-col h-full">
            <div class="flex flex-row w-full h-full gap-2">
                <div class="flex flex-col w-[65%]">
                    <table class="w-full shadow-md">
                        <thead>
                            <tr class="text-left bg-primary text-white">
                                <th class="p-2 px-3">Queue Number</th>
                                <th class="p-2 px-3">Office</th>
                                <th class="p-2 px-3">Status</th>
                                <th class="p-2 px-3 text-center">Action</th>
                            </tr>
                        </thead>
        
                        <tbody id="tbody">
                            @foreach ($queues as $index => $queue)
                                <tr class="{{$index%2 == 0 ? 'bg-white' : 'bg-slate-200'}}">
                                    <td class="p-2 px-3">{{$queue->code}}</td>
                                    <td class="p-2 px-3">{{$queue->office}}</td>
                                    <td class="p-2 px-3">{{$queue->status == 0 ? 'Pending' : 'Called'}}</td>
                                    <td class="p-2 px-3 text-center">Serve</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col flex-1 rounded-md ">
                    <div class="flex flex-col justify-center items-center py-2 bg-primary text-white">
                        <p>Active Window</p>
                        <p>Window Name</p>
                    </div>

                    <div class="flex flex-col justify-center items-center flex-1">
                        <p>Current Serving</p>
                        <p >Queue Number</p>
                        <p id="queue_number">
                            {{$current->code ?? 'None'}}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 p-1">
                        <button id="stop" class="{{$window->status == 1 ? '' : 'pointer-events-none button-inactive'}} button bg-red-400">Stop</button>
                        <button id="start" class="{{$window->status == 1 ? 'pointer-events-none button-inactive' : ''}} button bg-green-400">Start</button>
                        <div class="relative w-full">
                            <div id="next_modal" class="flex flex-col absolute bottom-[calc(100%+5px)] right-[0%] bg-white shadow-lg rounded-md p-5 min-h-[300px] justify-between hidden">
                                <div class="flex flex-col whitespace-nowrap">
                                    <label for="office_id">Move to office: </label>
                                    <select name="office_id" id="office_id">
                                        <option value=null>None</option>
                                        @foreach ($offices as $office)
                                            <option value="{{$office->id}}">{{$office->name}}</option>
                                        @endforeach
                                    </select>

                                    <label for="window_id">Window: </label>
                                    <select name="window_id" id="window_id">
                                        <option value=null>None</option>
                                    </select>
                                </div>

                                <div class="flex flex-col whitespace-nowrap gap-2">
                                    <button id="mnq" class="button bg-green-500 text-white px-5">Move and next queue</button>
                                </div>
                            </div>
                            <button id="next" class="{{$window->status == 1 ? '' : 'pointer-events-none button-inactive'}} button bg-primary text-white w-full">Next</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-layout>