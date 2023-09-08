@if(session()->has('message'))
{{-- AlpineJS to show the  message  --}}
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3500)"
        x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2
        bg-laravel text-white px-46 px-6 py-3 rounded-md">
    <p>
        {{session('message')}}
    </p>
@endif