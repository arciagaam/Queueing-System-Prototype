<x-layout>
    <form action="/screens/new/step-two" method="POST" class="flex flex-col gap-4 w-[50%] items-start">
        @csrf

        <div class="input-group">
            <label class="flex gap-1" for="name">Monitor name: <p class="text-small text-red-400">*</p></label>
            <input type="text" name="name" id="name" class="input">
        </div>

        <div class="input-group">
            <label class="flex gap-1" for="office_id">Select office to be monitored: <p class="text-small text-red-400">*</p></label>
            <select name="office_id" id="office_id" class="input">
                @foreach ($offices as $office)
                    <option value="{{$office->id}}">{{$office->name}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="button bg-secondary text-white mt-5">Add Monitor</button>
    </form>
</x-layout>