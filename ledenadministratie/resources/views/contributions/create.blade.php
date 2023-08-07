
<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a new contribution
            </h2>
        </header>

        <form method="POST" action="/contributions" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="membership_id">Membership:</label>
                <select name="membership_id" required>
                    @foreach ($memberships as $membership)
                    <option value="{{ $membership->id }}">{{ $membership->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="amount" class="inline-block text-lg mb-2">Base contribution:</label>
                <input type="integer" class="border border-gray-200 rounded p-2 w-full" name="amount" />
                {{--Error handeling for differnt labels--}}
                @error('amount')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="min_age" class="inline-block text-lg mb-2">Min age:</label>
                <input type="integer" class="border border-gray-200 rounded p-2 w-full" name="min_age"/>
                
                @error('min_age')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="max_age" class="inline-block text-lg mb-2">Max age:</label>
                <input type="integer" class="border border-gray-200 rounded p-2 w-full" name="max_age" />
                
                @error('max_age')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="discount" class="inline-block text-lg mb-2">Discount:</label>
                <input type="integer" class="border border-gray-200 rounded p-2 w-full" name="discount" />
                
                @error('discount')
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

