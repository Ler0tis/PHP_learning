@props(['family'])

  <div class="flex">
    <div>
      <h3 class="text-2xl">
        <a href="/families/{{$family->id}}">{{$family->name}}</a>
      </h3>
      <div class="text-xl font-bold mb-4">{{$family->address}}</div>
      <div class="text-lg mt-4">
        <i class="fa-solid fa-location-dot"></i> {{$family->email}}
      </div>
    </div>
  </div>
