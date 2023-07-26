<x-layout>
    <a href="/" class="inline-block text-black ml-4 mb-4">
    <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="mx-4">
            <div class="flex flex-col items-center justify-center text-center"F>
                <img class="w-48 mr-6 mb-6 rounded-lg" src="{{$family->picture ? asset('storage/' . $family->picture)
                : asset('/images/ironmanlogo.jpg')}}" alt="" />

                <h3 class="text-2xl font-bold mb-2">{{$family->name}}</h3>
                <div class="text-xl font mb-4">
                    <i class="fa-solid fa-location-arrow"></i>{{$family->address}}
                </div>

                <x-family-tags :tagsCsv="$family->tags" />

                <div class="text-lg my-4">
                </div>
                <div class="border border-gray-200 w-full mb-6"></div>
                <div>
                    <h3 class="text-3xl font-bold mb-4">
                        Familieleden
                    </h3>
                    <div class="text-lg space-y-6">
                        {{$family->description}}

                        <ul>
                            @foreach ($family->familymembers as $familymember)
                                <li>{{$familymember->picture}}</li>
                                <li>{{$familymember->name}} - {{$familymember->date_of_birth}}
                                 {{--<a href="{{route('familymember.edit', ['id => $familymember->id']) }}">Edit--}}</li>
                            @endforeach
                        </ul>

                        

                        <a href="{{ route('familymembers.create', ['family_id' => $family->id]) }}"
                            class="block bg-black text-white py-2 rounded-xl hover:opacity-80">
                            <i class="fa-solid fa-plus"></i>Maak familielid aan</a>

                        <a href="mailto:{{$family->email}}"
                            class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80"><i
                            class="fa-solid fa-envelope"></i>
                            Contact Family</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
