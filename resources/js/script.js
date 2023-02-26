Echo.channel('queue')
    .listen('NewQueue', (e) => {
        updateTable();
    })
    .listen('UpdateQueue', (e) => {
        updateTable();
    })

const updateTable = () => {
    const tbody = document.querySelector('#tbody');
    tbody.innerHTML = '';
    fetch(`http://${window.location.hostname}:${8000}/api/queue/${officeId}/${windowId}`, {
        method: 'POST'
    })
        .then(res => res.json())
        .then(data => {
            data.forEach((queue,index) => {

                const tr = document.createElement('tr');
                if(index%2==0){
                    tr.classList.add('bg-white');
                }else{
                    tr.classList.add('bg-slate-200');
                }

                const code = document.createElement('td');
                code.classList.add('p-2', 'px-3');
                code.innerText = queue.code;
                
                const office = document.createElement('td');
                office.classList.add('p-2', 'px-3')
                office.innerText = queue.office;

                const status = document.createElement('td');
                status.classList.add('p-2', 'px-3');
                if(queue.status == 0){
                    status.innerText = 'Pending';
                }else {
                    status.innerText = 'Called';
                }

                const serve = document.createElement('td');
                serve.classList.add('p-2', 'px-3');
                serve.innerText = 'Serve';

                tr.append(code);
                tr.append(office);
                tr.append(status);
                tr.append(serve);
                tbody.append(tr);
            })

        });
}


const deleteData = (name, path) => {
    if(confirm(`Are you sure you want to delete '${name}'`)){
        fetch(`http://${window.location.hostname}:${8000}/${path}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        window.location.reload();
    }
}

document.querySelector('#stop').addEventListener('click', async () => {
    await updateWindow('stop');
    window.location.reload();

})

document.querySelector('#start').addEventListener('click', async () => {
    await updateWindow('start');
    window.location.reload();
})

document.querySelector('#next').addEventListener('click', async (e) => {
    if(document.querySelector('#queue_number').innerText == 'None') {
        const response = await updateWindow('next', {next:0});
        updateTable();
    
        if(response.status != 'success'){
            alert(response.status);
        }
    
        document.querySelector('#queue_number').innerText = response?.data?.code || 'None';
    }else{
        document.querySelector('#next_modal').classList.toggle('hidden');
        e.stopPropagation();
    }
})

document.querySelector('#office_id').addEventListener('change', () => {
    const selectedOffice = document.querySelector('#office_id');
    fetch(`http://${window.location.hostname}:${8000}/api/windows/${selectedOffice.value}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        const select = document.querySelector('#window_id');
        select.innerHTML = '';
        if(data.length != 0){
            data.forEach(_window => {
    
                const option = document.createElement('option');
                option.value = _window.id;
                option.innerText = _window.number;
    
                select.append(option);
            })
        }else{
            const option = document.createElement('option');
            option.value = 'null';
            option.innerText = 'None';

            select.append(option);
        }
    })
})

document.addEventListener('click', (e) => {
    const target = e.target;
    const nextModal = document.getElementById("next_modal");

    if (!nextModal.classList.contains('hidden') && target !== nextModal && !nextModal.contains(target)) {
        document.querySelector('#next_modal').classList.toggle('hidden');
    }

    e.stopPropagation();
})

document.querySelector('#mcc').addEventListener('click', async () => {
    const selectedOffice = document.querySelector('#office_id').value;
    const selectedWindow = document.querySelector('#window_id').value;
    const response = await updateWindow('next', {selectedOffice:selectedOffice, selectedWindow:selectedWindow, next:1});

    if(response.status != 'success'){
        alert(response.status);
    }

    document.querySelector('#next_modal').classList.toggle('hidden');
    window.location.reload();
})

document.querySelector('#mnq').addEventListener('click', async () => {
    const selectedOffice = document.querySelector('#office_id').value;
    const selectedWindow = document.querySelector('#window_id').value;

    const response = await updateWindow('next', {selectedOffice:selectedOffice, selectedWindow:selectedWindow, next:2});
    updateTable();

    if(response.status != 'success'){
        alert(response.status);
    }
    
    document.querySelector('#next_modal').classList.toggle('hidden');
    document.querySelector('#queue_number').innerText = response?.data?.code || 'None';
})


async function updateWindow(action, payload = null) {
    const data = await fetch(`http://${window.location.hostname}:${8000}/update_window`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            action: action,
            windowId: windowId,
            officeId: officeId,
            payload: payload,
        })
    }).then(res => res.json())
        .then(data => { return data })

    return data;
}