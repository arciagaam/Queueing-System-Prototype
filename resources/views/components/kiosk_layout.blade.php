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

    <div class="flex flex-row w-full min-h-screen text-primary">

        <div class="flex justify-center items-center bg-primary min-w-[40%]">
            <img src="/images/logo.png" class="w-[300px]" alt="">
        </div>
    
        <div class="flex flex-1 flex-col bg-white justify-center items-center py-40 px-10 gap-10">
    
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