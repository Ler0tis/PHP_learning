<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-xxl mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                List of contributions
            </h2>
        </header>

        <div class="mb-6">
            @if ($contributions->isEmpty())
                <p>No contributions found.</p>
            @else
            <div class ="w-full">
                <table class="w-full table-auto rounded-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Financial Year</th>
                            <th class="text-center">Membership</th>
                            <th class="text-center">Min age</th>
                            <th class="text-center">Max age</th>
                            <th class="text-center">Discount</th>
                        </tr>
                    </thead>

                    @foreach ($contributions as $contribution)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
                            {{ $contribution->financialYear->year }}
                        </td>

                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
                            {{ $contribution->membership->description }}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
                            {{ $contribution->min_age }}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
                            {{ $contribution->max_age }}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
                            {{ $contribution->discount_with_symbol }}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center">
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
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>

        <div class="mb-6">
            <a href="/contributions/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                Create new contribution
            </a>
        </div>
    </div>
</x-layout>