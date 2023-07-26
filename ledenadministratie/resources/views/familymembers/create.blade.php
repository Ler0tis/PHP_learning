{{--Get the form and input send to DATABASE--}}

<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Maak een nieuw familielid aan
            </h2>
        </header>

        <form method="POST" action="/familymembers" enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Naam</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                    placeholder="Voornaam" value="{{old('name')}}" />
                {{--Error handeling for differnt labels--}}
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date_of_birth" class="inline-block text-lg mb-2">Geboortedatum</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="date_of_birth"
                    placeholder="DD-MM-YYYY" value="{{old('date_of_birth')}}" />

                @error('date_of_birth')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">E-mail</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                    placeholder="email@outlook.com" value="{{old('email')}}" />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (Komma gescheiden)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                    placeholder="Laravel, Zwemmen, OCR, etc" value="{{old('tags')}}" />

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="picture" class="inline-block text-lg mb-2">
                    Profielfoto
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />

                @error('picture')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            
            <input type="hidden" name="family_id" value="{{$family_id}}"

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Opslaan
                </button>

                <a href="/" class="text-black ml-4"> Annuleren </a>
            </div>
        </form>
    </div>
</x-layout>