<x-layout>
    <form action="/offices/{{$office->id}}/edit" method="POST" class="flex flex-col gap-4 w-[50%] items-start">
        @csrf

        <div class="input-group">
            <label class="flex gap-1" for="name">Office Name <p class="text-small text-red-400">*</p></label>
            <input type="text" id="name" name="name" placeholder="Enter office name" class="input" value="{{$office->name}}">
        </div>
        

        
        <div class="input-group">
            <label class="flex gap-1" for="prefix">Office Prefix <p class="text-small text-red-400">*</p></label>
            <input type="text" id="prefix" name="prefix" placeholder="Enter office prefix" class="input" maxlength="3" value="{{$office->prefix}}">
            <div class="flex flex-row gap-5">
                <p class="text-xs text-gray-500 italic">max character length 3</p>
                <p class="text-xs text-gray-500 italic">examples: TO, RO, T, R, TOF, ROF</p>
            </div>
        </div>

        <div class="flex flex-row gap-5">
            <a href="/offices" class="button bg-transparent text-red-500 mt-5">Cancel</a>
            <button type="submit" class="button bg-secondary text-white mt-5">Edit Office</button>
        </div>
    </form>
</x-layout>

<script>
    // FORCE PREFIX UPPERCASE
    document.querySelector('#prefix').addEventListener('input', function(){
        this.value = this.value.toUpperCase();
    })
</script>