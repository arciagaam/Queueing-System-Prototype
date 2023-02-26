<x-kiosk_layout>

    <form action="/queueing/step-one" method="POST">
        @csrf

        <div class="flex flex-col gap-1 justify-center items-center">
            <label class="flex gap-1" for="office_id">Select Office</label>

            <select name="office_id" id="office_id">
            @foreach ($offices as $office)
        
            <option value="{{$office->id}}">{{$office->name}}</option>
            @endforeach
        </select>
        </div>

        <div class="flex flex-row gap-10">
            <a href="/">Back</a>
            <button type="submit">Next</button>
        </div>
    </form>

</x-kiosk_layout>
