{{--Get the form and input send to DATABASE--}}

<x-layout>
    <a href="/" class="inline-block text-black ml-4 mb-4">
     <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create new family
            </h2>
        </header>

        <form method="POST" action="/families" enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Family name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                placeholder="Example: Skywalker"
                value="{{old('name')}}" />
                {{--Error handeling for differnt labels--}}
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="inline-block text-lg mb-2">Address</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="address"
                placeholder="Example: Zandweg 1, 2233GG, Utrecht"
                value="{{old('address')}}" />

                @error('address')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">E-mail</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                placeholder="Example: email@outlook.com"
                value="{{old('email')}}" />

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
                value="{{old('website')}}" />

                @error('website')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (comma seperated)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                placeholder="Example: Laravel, Swimming, OCR, etc"
                value="{{old('tags')}}" />

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <!-- <div class="mb-6">
                <label for="picture" class="inline-block text-lg mb-2">
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />

                @error('picture')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> -->

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

