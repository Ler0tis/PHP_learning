
{{--Use the x-layout instead of extends and section for better maintainability--}}

<x-layout>
    @include('partials._search')

    <div class="content-container">
        <header>
            <h1 class="text-3xl text-center font-bold my-5 uppercase">
                Overview families
            </h1>
        </header>

        <div class="lg:flex mx-4 space-y-4 md:space-y-0">
            <div class="lg:w-4/5">
                @if(count($families) == 0)
                    <p>No families found.</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 bg-gray-100">
                        @foreach($families as $family)
                            <x-family-card :family="$family" />
                        @endforeach
                    </div>

                    <div class="mt-6 p-4">
                        {{$families->links()}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>


