<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    @vite('resources/css/app.css')
</head>
<body>

    <div class="flex flex-row w-full min-h-screen">

        <div class="flex bg-red-300 min-w-[40%]">
            
        </div>
    
        <div class="flex flex-1 flex-col bg-white justify-start items-center py-40 px-10 gap-10">
    
            <div class="flex flex-row gap-2">
                <p>1</p>
                <p>></p>
                <p>2</p>
                <p>></p>
                <p>3</p>
            </div>

            <div class="flex flex-col justify-start items-center">
                {{$slot}}
            </div>

        </div>
    
    
    </div>
    
</body>
</html>