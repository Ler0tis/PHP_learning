
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
                                <a href="{{ route('financialyears.index', ['financialyear' => $financialYear->id]) }}">
                                    {{ $financialYear->year }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </table>
            @endif
        </div>
    </div>
</x-layout>