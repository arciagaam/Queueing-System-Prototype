<x-layout>
    {{-- Breadcrumbs --}}
    <div class="flex flex-row">
        <p class="font-bold text-lg">Manage Monitors</p>
    </div>

    <div class="grid grid-cols-4 3 gap-3">
        @foreach ($monitors as $monitor)
            <div class="flex flex-col p-2 shadow-md rounded-md min-h-[220px] justify-between gap-5">
                <a href="/screens/{{ $monitor->id }}">
                    <div class="bg-slate-100 min-h-[130px]">

                    </div>

                    <div class="flex flex-col">
                        <p class="font-bold text-md">{{ $monitor->name }}</p>
                    </div>
                </a>

                <div class="flex flex-row gap-2 self-end font-regular text-sm">
                    <a href="/screens/{{ $monitor->id }}/edit">Edit</a>
                    <p onclick="deleteData('{{ $monitor->name }}', '/screens/{{ $monitor->id }}/delete')" class="cursor-pointer">Delete</p>
                </div>
            </div>
        @endforeach

        <a href="/screens/new/step-one" class="flex flex-col p-2 shadow-md rounded-md min-h-[220px]">
            <div class="flex flex-1 flex-col gap-2 justify-center items-center">
                <p class="text-5xl font-extrabold text-gray-500">+</p>
                <p class="text-lg font-bold text-gray-500">Add Monitor</p>
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
