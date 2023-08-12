
<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-xl mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Financial Years
            </h2>
        </header>

        <div class="mb-6">
            @if ($financialYears->isEmpty())
                <p>No financial years found.</p>
            @else
                <table class="w-full table-auto rounded-sm">
                   <h1>Financial Years</h1>
                    <ul>
                        @foreach ($financialYears as $financialYear)
                            <li>
                                <a href="{{ route('financial-years.show', $financialYear) }}">
                                    {{ $financialYear->year }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{ $contribution->amount_with_symbol }}
                        </td>

                        {{-- <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{ route('contributions.edit', ['contribution' => $contribution->id]) }}"
                                    class="text-blue-400 px-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="/contributions/{{$contribution->id}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500" onclick="return confirm('Are you sure you want to delete this contribution?')">
                                        <i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td> --}}
                    
                </table>
            @endif
        </div>
    </div>
</x-layout>