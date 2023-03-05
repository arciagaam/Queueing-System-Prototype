<x-layout>
    
    <form action="/screens/{{$monitor_id}}/new" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 w-[50%] items-start">
        @csrf
        <div class="flex flex-col gap-2">
            <label class="flex gap-1" for="name">Office Name <p class="text-small text-red-400">*</p></label>
            <input type="file" id="file" name="file">
        </div>

        <button type="submit" class="button bg-secondary text-white">Add content</button>

    </form>

</x-layout>