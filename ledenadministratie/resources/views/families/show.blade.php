@php
    use Carbon\Carbon;
@endphp

<x-layout>
    <a href="{{ route('familymembers.create', ['family_id' => $family->id]) }}"
        class="w-40 whitespace-nowrap block bg-black text-white py-2 rounded-xl hover:opacity-80">
        <i class="fa-solid fa-plus"></i> Add member</a>

    <div class="mx-4">
        <div class="flex flex-col items-center justify-center text-center">
            <h3 class="text-2xl font-bold mb-2">{{$family->name}}</h3>
            <div class="text-xl font mb-4">
                <i class="fa-solid fa-location-arrow"></i>{{$family->address}}
            </div>

            <x-family-tags :tagsCsv="$family->tags" />

            <div class="text-lg my-4">{{$family->description}}</div>
            <div class="border border-gray-200 w-full mb-6"></div>
            <div>
                <h3 class="text-3xl font-bold mb-4">
                    Familymembers
                </h3>
                <table class="w-full table-auto rounded-sm">
                    <tbody>
                        @unless(is_null($family->familymembers) || $family->familymembers->count() === 0)
                        @foreach ($family->familymembers as $familymember)

                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <img class="w-48 mr-6 mb-6 rounded-lg" src="{{ $familymember->picture ? asset('storage/' . $familymember->picture) : 
                                        asset('/images/no-image.png') }}" alt="" />
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <p>Name: {{ $familymember->name }} {{ $family->name }} </p>
                                <p>Birthdate: {{ Carbon::createFromFormat('Y-m-d', $familymember->date_of_birth)->format('d-m-Y') }}</p>
                                <p>E-mail: {{$familymember->email}} </p>
                                <p>Current membership: {{ $familymember->contribution ? $familymember->contribution->membership->description : 'No membership' }}</p>
                                <p>Contribution: {{ $familymember->contribution ? $familymember->contribution->amount : 'No contribution' }}</p>
                                @if ($familymember->contribution)
                                <p>Discount: {{ $familymember->contribution->amount * ($familymember->contribution->membership->discount / 100) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="{{ route('familymembers.edit', ['familymember' => $familymember->id]) }}"
                                    class="text-blue-400 px-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/familymembers/{{$familymember->id}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300
                                            text-lg">
                                <p class="text-center">No members found</p>
                            </td>
                        </tr>
                        @endunless
                    </tbody>
                </table>
                <a href="mailto:{{$family->email}}" class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80"><i
                        class="fa-solid fa-envelope"></i>
                    Contact Family</a>
            </div>
        </div>
    </div>
    </div>
</x-layout>
