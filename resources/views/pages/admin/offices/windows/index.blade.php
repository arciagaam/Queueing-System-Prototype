
<x-layout>
    {{-- Breadcrumbs --}}
    <div class="flex flex-row gap-2 items-center">
        <p class="font-regular text-lg">Manage Offices</p>
        <p>></p>
        <p class="font-bold text-lg">{{$office->name}}</p>
    </div>

    <div class="grid grid-cols-4 3 gap-3">
        @foreach ($windows as $window)
        <div class="flex flex-col p-2 shadow-md rounded-md min-h-[220px] justify-between gap-5">

            <a href="/offices/{{$office->id}}/{{$window->id}}" >
                <div class="bg-slate-100 min-h-[130px]">

                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex flex-row justify-between items-center">
                        <p class="font-bold text-md">Window {{$window->number}}</p>
                        <p class="font-regular text-sm">Status: {{$window->status == 0 ? 'Inactive' : 'Active'}}</p>
                    </div>
                    <p class="font-bold text-xs">{{$window->name}}</p>
                    
                    <p class="font-regular text-sm">Purpose: {{$window->purpose}}</p>
                </div>
 
            </a>

            <div class="flex flex-row gap-2 self-end font-regular text-sm">
                
                <a href="/offices/{{$office->id}}/{{$window->id}}/edit">Edit</a>
                <p onclick="deleteData('{{ $window->number }}', '/offices/{{ $office->id }}/{{ $window->id }}/delete')" class="cursor-pointer">Delete</p>
            </div>

        </div>
        @endforeach

        <a href="/offices/{{$office->id}}/new" class="flex flex-col p-2 shadow-md rounded-md min-h-[220px]">
            <div class="flex flex-1 flex-col gap-2 justify-center items-center">
                <p class="text-5xl font-extrabold text-gray-500">+</p>
                <p class="text-lg font-bold text-gray-500">Add Window</p>
            </div>
        </a>
    </div>
</x-layout>

<script>
    const deleteData = (name, path) => {
        if (confirm(`Are you sure you want to delete '${name}'`)) {
            fetch(`http://${window.location.hostname}:${8000}${path}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            window.location.reload();
        }
    };
</script>