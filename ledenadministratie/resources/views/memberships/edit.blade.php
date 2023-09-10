{{--Get the form and input send to DATABASE--}}

<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit a membership
            </h2>
        </header>

        <form method="POST" action="{{ route('memberships.update', ['membership' => $membership->id]) }}"
            enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">Name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="description"
                placeholder="Example: Junior"/>
                {{--Error handeling for differnt labels--}}
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

