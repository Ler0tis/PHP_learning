
{{--Use the x-layout instead of extends and section for better maintainability--}}
<x-layout>

    {{--Zet de partials die je wilt zien op de betreffende page hier.--}}
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

    @if(count($families) == 0)
        <p>No families found.</p>
    @endif

    @foreach($families as $family)
    <x-family-card :family="$family" />
    @endforeach

    </div>
</x-layout>


