Echo.channel('call')
    .listen('NewCall', (e) => {
        updateQueue();
    })


function updateQueue() {

    fetch(`http://${window.location.hostname}:${8000}/monitor/queue/${office_id}/`, {
        method: 'GET',
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
        }
    })
        .then(res => res.json())
        .then(data => {
            const queueContainer = document.querySelector('#queue-container');

            if (data.length > 0) {

                queueContainer.innerHTML = '';

                data.forEach((queue, index) => {
                    const grid = document.createElement('div');
                    grid.classList.add('h-[20%]', 'inline-grid', 'grid-cols-2');

                    const code = document.createElement('div');
                    code.innerText = queue.code;
                    code.classList.add('text-8xl', 'flex', 'items-center', 'justify-center', 'px-5', 'font-bold', 'text-white')
                    index % 2 == 0 ? code.classList.add('bg-secondary') : code.classList.add('bg-[#0FAC7B]');

                    const number = document.createElement('div');
                    number.innerText = queue.number;
                    number.classList.add('text-8xl', 'flex', 'items-center', 'justify-center', 'px-5', 'font-bold', 'text-primary')
                    index % 2 == 0 ? number.classList.add('bg-white') : number.classList.add('bg-[#E1E1E1]');

                    queueContainer.append(grid);
                    grid.append(code);
                    grid.append(number);
                    queueContainer.append(grid);
                });

            } else {

            }
        })

}

window.addEventListener('load', async () => {
    let counter = 0;

    const slideshow = () => {

        const content = document.querySelector(`[data-index='${counter}']`);
        const prev = document.querySelector(`[data-index='${counter-1}']`);

        counter++;

        if (content.tagName == 'IMG') {
            content.classList.toggle('hidden');

            if(prev){
                prev.classList.toggle('hidden');
            }

            setTimeout(() => {
                if(counter == contentCount) {
                    document.querySelector(`[data-index='${contentCount-1}']`).classList.toggle('hidden');
                    counter = 0;
                }
                slideshow();
            }, 10000);

        } else {
            content.classList.toggle('hidden');
            content.play()

            if(prev){
                prev.classList.toggle('hidden');
            }

            content.onended = function () {
                if(counter == contentCount) {
                    document.querySelector(`[data-index='${contentCount-1}']`).classList.toggle('hidden');
                    counter = 0;
                }
                slideshow();
            }
        }
    }

    slideshow();
})

