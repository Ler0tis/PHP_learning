@props(['tagsCsv'])

{{--Takes the value from databae and removes the komma. And puts it the array $tags --}}
@php
    $tags = explode(',', $tagsCsv);
@endphp

<ul class="flex">
    @foreach ($tags as $tag )
    <li class="flex items-center justify-center bg-black
    text-white rounded-xl py-1 px-3 mr-2 text-xs">
    {{--To click the link on the tag that is selected--}}
        <a href="/?tag={{$tag}}">{{$tag}}</a>
    </li>
    @endforeach
</ul>