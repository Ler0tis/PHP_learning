
<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit family
            </h2>

            <h3 class="mb-4"> Current family to edit: {{$family->name}}</h3>
        </header>

        <form method="POST" action="/families/{{$family->id}}" enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            @method('PUT') {{--This, because in FORM method you can only use POST and GET--}}
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Family name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                placeholder="Example: Skywalker"
                value="{{$family->name}}" />
                {{--Error handeling for differnt labels--}}
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="inline-block text-lg mb-2">Address</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="address"
                    placeholder="Example: Vlietstraat 1, 2233GG, Utrecht"
                    value="{{$family->address}}" />

                    @error('address')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">E-mail</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                placeholder="Example: email@outlook.com"
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
                    Tags (comma seperated)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                    placeholder="Example: Laravel, Zwemmen, OCR, etc"
                    value="{{$family->tags}}" />

                    @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
            </div>

            <div class="mb-6">
                @error('picture')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    Additional information
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                    placeholder="Notes, appointments, etc">{{old('description')}}</textarea>
            
                @error('description')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Save
                </button>

                <a href="/" class="text-black ml-4"> Cancel </a>
            </div>
        </form>
    </div>
</x-layout>

