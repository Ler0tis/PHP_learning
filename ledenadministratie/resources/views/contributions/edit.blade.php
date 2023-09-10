
<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit contribution
            </h2>
        </header>

        <form method="POST" action="{{ route('contributions.update', 
            ['contribution' => $contribution->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div >
                <label for="membership_id" class="bg-laravel text-white rounded">Membership</label>
                <select name="membership_id" required>
                    @foreach ($memberships as $membership)
                    <option value="{{ $membership->id }}" 
                    @if($contribution->membership_id == $membership->id) selected @endif>
                    {{ $membership->description }}</option>
                    @endforeach
                </select>
                @error('membership_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="min_age" class="inline-block text-lg mb-2">Minimum Age</label>
                <input type="number" class="border border-gray-200 rounded p-2 w-full" 
                name="min_age" value="{{ $contribution->min_age }}"/>
                
                @error('min_age')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="max_age" class="inline-block text-lg mb-2">Maximum Age</label>
                <input type="number" class="border border-gray-200 rounded p-2 w-full"
                 name="max_age" value="{{ $contribution->max_age }}" />
                
                @error('max_age')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="discount" class="inline-block text-lg mb-2">Discount in %</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" 
                name="discount" value="{{ $contribution->discount }}"/>
                
                @error('discount')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Update
                </button>

                <a href="/" class="text-black ml-4"> Cancel </a>
            </div>
        </form>
    </div>
</x-layout>

