<!DOCTYPE html>
<html>
<head>
@yield('link')
</head>
<body>
    <div class="container">
        @section('sidebar')
            This is master sidebar
        @show
        @yield('content')
    </div>
</body>
</html>

