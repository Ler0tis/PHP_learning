<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                List of contributions
            </h2>
        </header>

        <div class="mb-6">
            @if ($contributions->isEmpty())
            <p>No contributions found.</p>
            @else
            <table class="w-full table-auto rounded-sm">
                <thead>
                    <tr>
                        <th>Membership</th>
                        <th>Min age</th>
                        <th>Max age</th>
                        <th>Discount</th>
                        <th>Total per year</th>
                    </tr>
                </thead>

                @foreach ($contributions as $contribution)
                <tr>
                    <td>{{ $contribution->membership->description }}</td>
                    <td>{{ $contribution->min_age }}</td>
                    <td>{{ $contribution->max_age }}</td>
                    <td>{{ $contribution->discount }}%</td>
                    <td>€{{ $contribution->amount }}</td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>

        <div class="mb-6">
            <a href="/contributions/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                Create new contribution
            </a>
        </div>
    </div>
</x-layout>