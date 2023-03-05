<x-layout>
    <form action="/offices/{{$office_id}}/{{$window->id}}/edit" method="POST" class="flex flex-col gap-4 w-[50%] items-start">
        @csrf

        <div class="input-group">
            <label class="flex gap-1" for="number">Window Number<p class="text-small text-red-400">*</p></label>
            <input type="number" id="number" name="number" placeholder="Enter number" value="{{$window->number}}" class="input">
            @error('number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label class="flex gap-2 items-center" for="name">Window Name<p class="text-xs text-gray-400">optional
                </p></label>
            <input type="text" id="name" name="name" placeholder="Enter window name" class="input" value="{{$window->name}}">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label class="flex gap-1" for="purpose">Window Purpose</label>
            <input type="text" id="purpose" name="purpose" placeholder="Enter purpose" value="{{$window->purpose}}" class="input">
            @error('purpose')
                <div>{{ $message }}</div>
            @enderror
        </div>


        <div class="flex flex-row gap-5">
            <a href="/offices/{{$office_id}}" class="button bg-transparent text-red-500 mt-5">Cancel</a>
            <button type="submit" class="button bg-secondary text-white mt-5">Edit Office</button>
        </div>
    </form>
</x-layout>