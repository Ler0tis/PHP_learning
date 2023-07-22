
<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Familie bewerken
            </h2>
            <p class="mb-4">Edit: {{$family->name}}</p>
        </header>

        <form method="POST" action="/families/{{$family->id}}" enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            @method('PUT') {{--This, because in FORM method you can only use POST and GET--}}
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Familienaam</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                placeholder="Voorbeeld: Skywalker"
                value="{{$family->name}}" />
                {{--Error handeling for differnt labels--}}
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="inline-block text-lg mb-2">Adres</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="address"
                    placeholder="Voorbeeld: Zandweg 1, 2233GG, Utrecht"
                    value="{{$family->address}}" />

                    @error('address')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">E-mail</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                placeholder="Voorbeeld: email@outlook.com"
                value="{{$family->email}}" />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="website" class="inline-block text-lg mb-2">
                    Website URL
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="website"
                placeholder="https://www.google.nl/"
                value="{{$family->website}}" />

                @error('website')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (Komma gescheiden)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                    placeholder="Voorbeeld: Laravel, Zwemmen, OCR, etc"
                    value="{{$family->tags}}" />

                    @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
            </div>

            <div class="mb-6">
                <label for="picture" class="inline-block text-lg mb-2">
                    Familiefoto
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />

                <img class="w-48 mr-6 mb-6 rounded-lg" src="{{$family->picture ? asset('storage/' . 
                $family->picture) : asset('/images/ironmanlogo.jpg')}}" alt="" />

                @error('picture')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    Beschrijving
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                    placeholder="Include tasks, requirements, salary, etc">{{$family->description}}
                </textarea>

                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
            </div>

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Opslaan
                </button>

                <a href="/" class="text-black ml-4"> Annuleren </a>
            </div>
        </form>
    </div>
</x-layout>

