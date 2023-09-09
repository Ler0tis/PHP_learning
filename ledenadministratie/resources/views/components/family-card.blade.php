@props(['family'])

{{-- Overview families --}}
  <div class="flex">
    <div>
      <h3 class="text-xl font-bold">
        <a href="/families/{{$family->id}}">{{  $family->name }}</a>
      </h3>
      <div class="text-xl mb-4 max-w-[18rem] text-left">{{ $family->address }}</div>
    </div>
  </div>

  

