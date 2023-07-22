@props(['family'])


{{-- Overzicht families --}}

  <div class="flex">
    <img class="hidden w-48 mr-6 md:block"
    src="{{$family->picture ? asset('storage/' . $family->picture)
     : asset('/images/ironmanlogo.jpg')}}" alt="" />
    <div>
      <h3 class="text-2xl font-bold">
        <a href="/families/{{$family->id}}">{{$family->name}}</a>
      </h3>
      <div class="text-xl mb-4">{{$family->address}}</div>
    </div>
  </div>

