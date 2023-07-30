<x-layout>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Memberships List
            </h2>
        </header>

        <div class="mb-6">
            @if ($memberships->isEmpty())
                <p>No memberships found.</p>
            @else
                <ul>
                    @foreach ($memberships as $membership)
                        <li>{{ $membership->description }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mb-6">
            <a href="/memberships/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                Create New Membership
            </a>
        </div>
    </div>
</x-layout>
