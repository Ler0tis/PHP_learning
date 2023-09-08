
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="public/images/ironmanlogo.jpg" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#E51937",
                        },
                    },
                },
            };
        </script>
        <title>Ledenadministratie</title>
    </head>
    <body class="mb-48">
        <a href="/">
            <img class="w-24" src="{{asset('images/ironmanlogo.jpg')}}" alt="" class="logo" />
        </a>
        @auth
        <div class="flex">
            <div class="w-1/8 flex-direction: column items-center justify-center">
                @include('partials._navigation')
            </div>
            
            <div class="w-3/4">
                <div class="fixed top-0 left-0 right-0 text-black p-4">
                    <nav class="flex justify-between items-center">
                        <ul class="flex space-x-4 mr-4 text-lg">
                            <li>
                                <span class="font-bold uppercase">
                                    Welcome {{ auth()->user()->name }}
                                </span>
                            </li>
                            <li>
                                <a href="/families/manage" class="hover:text-laravel">
                                    <i class="fa-solid fa-gear"></i>
                                    Manage families
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>


                <main>
                @endauth
                {{--Use the slot instead of YIELD if you want to make use of x-layout--}}
                {{$slot}}

                </main>
                <footer class="fixed bottom-0 left-0 w-full flex items-center justify-start 
                font-bold bg-laravel text-white h-24 mt-24 bg-opacity-80 md:justify-center">
                <p class="ml-2">Copyright &copy; 2023, All Rights reserved</p>
                </footer>
                <!-- Shows message that family/familymember is added/removed etc -->
                <x-flash-message />
            </div>
        </div>
    </body>
</html>