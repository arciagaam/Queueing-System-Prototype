<x-kiosk_layout>

    <form action="/queueing/step-two" method="POST" class="flex flex-col gap-5 self-center">
        @csrf

        <div class="flex flex-col gap-1 justify-center items-center gap-2">
            <div class="flex flex-col items-center gap-1">
                <label class="flex gap-1 font-bold text-4xl" for="office_id">Select an office:</label>
                <p class="flex gap-1 italic font-regular text-lg">Pumili ng opisina</p>
            </div>

            <select name="purpose" id="purpose" class="input w-full text-center">
                @foreach ($purposes as $purpose)
                    <option value="{{$purpose->purpose}}">{{ucfirst($purpose->purpose)}}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-row gap-10 items-center justify-center w-full">
   
                <a href="/" class="button text-lg font-medium border border-secondary text-secondary flex-1 min-h-[75px]">Back</a>
                <button type="submit" class="button text-lg font-medium bg-secondary text-white flex-1 min-h-[75px]">Next</button>
        
        </div>
    </form>

</x-kiosk_layout>