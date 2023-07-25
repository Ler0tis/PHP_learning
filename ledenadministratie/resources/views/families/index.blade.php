
{{--Use the x-layout instead of extends and section for better maintainability--}}
<x-layout>

    {{--Zet de partials die je wilt zien op de betreffende page hier.--}}
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:flex mx-4 space-y-4 md:space-y-0">
    {{--Navigatiemenu on the left side--}}
    

    <div class="lg:w-4/5">
        @if(count($families) == 0)
            <p>No families found.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
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
</x-layout>


