<x-layout>
    <div class="grid grid-cols-2 gap-3">
        @csrf


        <div id="1" class="card flex flex-col cursor-pointer">
            <div class="flex flex-row bg-slate-400 flex-1 min-h-[200px] gap-2 p-2">
                <div class="flex w-full bg-slate-300 rounded-md"></div>
                <div class="flex w-full flex-col gap-2">
                    <div class="flex flex-1 bg-slate-300 rounded-md"></div>
                    <div class="flex flex-[2] bg-slate-300 rounded-md"></div>
                </div>
            </div>
            <p>Layout 1</p>
        </div>

        <div id="2" class="card flex flex-col cursor-pointer">
            <div class="flex flex-row bg-slate-400 flex-1 min-h-[200px] gap-2 p-2">
                <div class="flex w-full bg-slate-300 rounded-md"></div>
                <div class="flex w-full bg-slate-300 rounded-md">
                </div>
            </div>
            <p>Layout 2</p>
        </div>


        <div id="3" class="card flex flex-col cursor-pointer">
            <div class="flex flex-row bg-slate-400 flex-1 min-h-[200px] gap-2 p-2">
                <div class="flex w-full bg-slate-300 rounded-md"></div>
                <div class="flex w-full flex-col gap-2">
                    <div class="flex flex-1 bg-slate-300 rounded-md"></div>
                    <div class="flex flex-[2] bg-slate-300 rounded-md"></div>
                </div>
            </div>
            <p>Layout 3</p>
        </div>

    </div>
</x-layout>

<script>
    window.addEventListener('load', () => {
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', async function() {
                await fetch(`http://${window.location.hostname}:${8000}/screens/new/step-one`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            id: this.id
                        })
                    }).then((res) => {
                    location.href = '/screens/new/step-two';
                })
            })
        })
    })
</script>
