<x-kiosk_layout>

    <div class="flex flex-col gap-12">
        <div class="flex flex-col items-center">
            <p class="font-bold text-3xl">Please take your receipt.</p>
            <p class="italic font-regular text-lg">Kunin ang iyong resibo.</p>
        </div>
    
        <a href="/home" class="button bg-secondary text-white text-xl w-full min-h-[75px]">Return</a>
    </div>

</x-kiosk_layout>

<script>
    window.addEventListener('load', ()=>{
        setTimeout(() => {
            location.href = '/home';
        }, 3000);
    })
</script>