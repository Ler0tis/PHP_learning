
{{--Use the x-layout instead of extends and section for better maintainability--}}

<x-layout>
    @include('partials._search')


    <div class="bg-gray-50 border border-gray-300 p-10 rounded max-w-lg mx-auto mt-20">
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
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 bg-gray-100">
                        @foreach($families as $family)
                            <x-family-card :family="$family" class="col-span-1 md:col-span-2"></x-family-card>
                            <div class="hidden md:block col-span-1"></div> <!-- Lege family voor de tussenruimte -->
                        @endforeach
                    </div>


                    <div class="mt-6 p-4">
                        {{$families->links()}}
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</x-layout>


