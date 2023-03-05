<x-layout>
    {{-- Breadcrumbs --}}
    <div class="flex flex-row gap-2 items-center">
        <p class="font-regular text-lg">Manage Monitors</p>
        <p>></p>
        <p class="font-bold text-lg">{{ $monitor->name }}</p>
    </div>

    <div class="flex flex-col gap-5">

        <div class="flex flex-row gap-4 items-center">

            <div class="flex flex-row gap-2 items-center">
                <p>Monitor link: </p>
                <p class="px-2 py-1 bg-slate-200 rounded-md">{{ request()->getSchemeAndHttpHost() }}/monitor/display/{{ $monitor->id }}</p>
            </div>

            <a target="_blank" href="/monitor/display/{{ $monitor->id }}">open in new tab</a>
        </div>

        <div class="grid grid-cols-4 3 gap-3">
            @foreach ($files as $file)
                    <div class="flex flex-col p-2 shadow-md rounded-md min-h-[220px] justify-between gap-5">

                        {{-- {{dd($file->file)}} --}}
                        <div>
                            <div style="background: url(../images/{{ $monitor->id }}/{{ $file->file }})"
                                class="relative bg-slate-100 min-h-[130px] !bg-cover !bg-center !bg-no-repeat">
                                <div id="image-inactive-{{ $file->id }}"
                                    class="{{ $file->active == 0 ? '' : 'hidden' }} absolute inset-0 bg-black/50 text-white font-medium text-lg flex items-center justify-center">
                                    Inactive
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex flex-row justify-between items-center mt-2">
                                    <p class="font-bold text-md">Type: {{ $file->type == 0 ? 'Image' : 'Video' }}</p>

                                    <div class="flex flex-row gap-2 items-center text-xs">
                                        <label for="{{$file->file}}">Toggle content: </label>
                                        <label data-id="{{ $file->id }}" for="{{$file->file}}"
                                            class="relative bg-gray-100 cursor-pointer w-10 h-5 rounded-full flex items-center">
                                            <input type="checkbox" id="{{$file->file}}" name="{{$file->file}}" class="sr-only peer" onchange="toggleActive({{ $file->id }})" {{ $file->active == 1 ? 'checked' : '' }}>
                                            <span class="absolute w-2/5 h-4/5 bg-primary rounded-full left-1 peer-checked:bg-secondary peer-checked:left-[calc(50%)] transition-all duration-200"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row gap-2 self-end font-regular text-sm">
                            <p onclick="" class="cursor-pointer">Delete</p>
                        </div>

                    </div>
            @endforeach

            <a href="/screens/{{ $monitor->id }}/new" class="flex flex-col p-2 shadow-md rounded-md min-h-[220px]">
                <div class="flex flex-1 flex-col gap-2 justify-center items-center">
                    <p class="text-5xl font-extrabold text-gray-500">+</p>
                    <p class="text-lg font-bold text-gray-500">Add Content</p>
                </div>
            </a>
        </div>


    </div>

    <script>
        function toggleActive(id) {
            const bg = document.querySelector(`#image-inactive-${id}`);
            let toggle = 1;

            if (bg.classList.contains('hidden')) {
                toggle = 0;
            }

            fetch(`http://${window.location.hostname}:${8000}/content/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: id,
                    toggle: toggle,
                })
            })

            bg.classList.toggle('hidden');
        }

        function updateMonitor(id, value) {
            fetch(`http://${window.location.hostname}:${8000}/monitor/content-update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: id,
                    value: value
                })
            })
            .then(() => {

            })
        }
    </script>


</x-layout>
