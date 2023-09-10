@php
    use Carbon\Carbon;
@endphp

<x-layout>
    <div class="mx-4">
        <div class="flex flex-col items-center justify-center text-center">
            <h3 class="text-2xl font-bold mb-2">Family: {{ $family->name }}</h3>
            <div class="text-xl font mb-4">
                <i class="fa fa-location-dot fa-lg pr-4"></i>{{ $family->address }}
            </div>
        
            <x-family-tags :tagsCsv="$family->tags" />
        
            <div class="text-lg my-4">{{ $family->description }}</div>
            <div class="border border-gray-200 w-full mb-6"></div>
        
            <div>
                <h4 class="text-lg font-bold mb-2">Total Contribution for this family per year: </h4>
                <p>
                    @php
                    $totalContribution = 0;
                    foreach ($family->familymembers as $familymember) {
                    $totalContribution += $calculatedAmounts[$familymember->id];
                    }
                    @endphp
                    € {{ $totalContribution }}
                </p>
            </div>
        </div>
                <h3 class="text-3xl font-bold mb-4">
                    Familymembers
                </h3>
                <a href="{{ route('familymembers.create', ['family_id' => $family->id]) }}"
                    class="w-40 whitespace-nowrap block bg-black text-white p-2 m-2 rounded-xl hover:opacity-80 text-center">
                    <i class="fa-solid fa-plus pr-2"></i>  Add member</a>
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
                                <p>Birthdate: {{ Carbon::parse($familymember->date_of_birth)->format('d-m-Y') }}</p>
                                <p>E-mail: {{$familymember->email}} </p>
                                @if (!is_null($familymember->membership_id))
                                    <p>Current membership: {{ $familymember->membership->description }}</p>
                                    <p>Contribution per year: € {{ $calculatedAmounts[$familymember->id] }}</p>
                                @else
                                <p>No membership</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('familymembers.edit', ['familymember' => $familymember->id]) }}" 
                                        class="text-blue-400 px-2 py-2 rounded-xl">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form method="POST" action="/familymembers/{{$familymember->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 px-2 py-2"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
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
                <a href="mailto:{{$family->email}}" class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80 text-center"><i
                        class="fa-solid fa-envelope pr-2"></i>
                    Contact Family</a>
            </div>
        </div>
    </div>
    </div>
</x-layout>
