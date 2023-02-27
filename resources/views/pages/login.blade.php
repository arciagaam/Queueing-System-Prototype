<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')


</head>

<body>

    <div class="grid place-items-center min-h-screen text-primary">

        <div class="flex flex-row w-[80%] max-w-[700px] border rounded-md overflow-hidden">

            <div class="flex flex-col w-[45%] items-center justify-center bg-primary">
                <img src="/images/logo.png" class="p-10" alt="">
            </div>

            <div class="flex flex-col flex-1 py-5 px-5 gap-8">
                <p class="font-medium text-2xl">Login</p>

                <form action="/login" method="POST" class="self-center w-full">
                    @csrf

                    <div class="flex flex-col gap-2 w-full">
                        
                        
                        <div class="input-group">
                            <label for="username" class="text-sm">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter username" class="input">
                        </div>
                        
                        <div class="input-group">
                            <label for="password" class="text-sm">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter password" class="input">
                        </div>

                        @error('password')
                            <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="button bg-secondary text-white font-medium mt-5">Login</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</body>

</html>
