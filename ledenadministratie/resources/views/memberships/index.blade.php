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
            <table class="w-full table-auto rounded-sm">
                @foreach ($memberships as $membership)
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <a href="/memberships/{{$membership->id}}">
                            {{$membership->description}}
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <a href="{{ route('memberships.edit', ['membership' => $membership->id]) }}"
                            class="text-blue-400 px-6 py-2 rounded-xl">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <form method="POST" action="/memberships/{{$membership->id}}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500" onclick="return confirm('Are you sure you want to delete this membership')">
                                <i class="fa-solid fa-trash"></i></button>      
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>  
            @endif
        </div>

        <div class="mb-6">
            <a href="/memberships/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                Create New Membership
            </a>
        </div>
    </div>
</x-layout>
