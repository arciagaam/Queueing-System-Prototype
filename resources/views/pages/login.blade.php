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

    <div class="grid place-items-center min-h-screen">

        <div class="flex flex-row w-[80%] max-w-[700px] border rounded-md py-5">

            <div class="flex flex-col w-[45%] items-center justify-center">
                yo
            </div>

            <div class="flex flex-col flex-1">
                <p>Login</p>

                <form action="/login" method="POST" class="self-center">
                    @csrf

                    <div class="flex flex-col gap-2">
                        
                        
                        <div class="flex flex-col gap-1">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter username">
                        </div>
                        
                        <div class="flex flex-col gap-1">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter password">
                        </div>

                        @error('password')
                            <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="self-end bg-primary text-white rounded-md py-1 px-3">Login</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</body>

</html>
