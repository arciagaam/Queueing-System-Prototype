<x-layout>
    <form action="/offices/{{ $office_id }}/new" method="POST" class="flex flex-col gap-4 w-[50%] items-start">
        @csrf

        <div class="input-group">
            <label class="flex gap-1" for="number">Window Number<p class="text-small text-red-400">*</p></label>
            <input type="number" id="number" name="number" placeholder="Enter number" class="input">
            @error('number')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label class="flex gap-2 items-center" for="name">Window Name<p class="text-xs text-gray-400">optional
                </p></label>
            <input type="text" id="name" name="name" placeholder="Enter window name" class="input">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label class="flex gap-1" for="purpose">Window Purpose<p class="text-small text-red-400">*</p></label>
            <input type="text" id="purpose" name="purpose" placeholder="Enter purpose" class="input">
            @error('purpose')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="button bg-secondary text-white mt-5">Add Window</button>
    </form>
</x-layout>
