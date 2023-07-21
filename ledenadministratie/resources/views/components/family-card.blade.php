@props(['family'])


{{-- Overzicht families --}}
  <div class="flex">
    <div>
      <h3 class="text-2xl font-bold">
        <a href="/families/{{$family->id}}">{{$family->name}}</a>
      </h3>
      <div class="text-xl mb-4">{{$family->address}}</div>

     
    </div>
  </div>
