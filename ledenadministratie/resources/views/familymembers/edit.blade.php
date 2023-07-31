{{--Get the form and input send to DATABASE--}}
@php
    use Carbon\Carbon;
@endphp

<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit family member
            </h2>
        </header>

        <form method="POST" action="{{ route('familymembers.update', ['familymember' => $familymember->id]) }}"
            enctype="multipart/form-data">
            {{--CSRF = against cross site scripting( SQL-INJECTION)--}}
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                    placeholder="First name" value="{{$familymember->name}}" />
                {{--Error handeling for differnt labels--}}
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date_of_birth" class="inline-block text-lg mb-2">Date of birth</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="date_of_birth"
                    placeholder="DD-MM-YYYY" value="{{ Carbon::createFromFormat('Y-m-d', $familymember->date_of_birth)->format('d-m-Y') }}" />

                @error('date_of_birth')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">E-mail</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                    placeholder="email@outlook.com" value="{{ $familymember->email }}" />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="picture" class="inline-block text-lg mb-2">
                    Profile picture
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />

                @error('picture')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Selectie voor de membership --}}
            <div class="mb-6">
                <label for="membership_id">Select Membership:</label>
                <select name="membership_id" id="membership_id">
                    <option value="">No Membership</option>
                    @foreach ($memberships as $membership)
                    <option value="{{ $membership->id }}" @if ($familymember->membership && 
                        $familymember->membership->id === $membership->id) selected @endif>
                        {{ $membership->description }}
                    </option>
                    @endforeach
                </select>

                @error('membership_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>
            
            <input type="hidden" name="familymember_id" value="{{ $familymember->id }}">

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Save
                </button>

                <a href="/" class="text-black ml-4"> Cancel </a>
            </div>
        </form>
    </div>
</x-layout>