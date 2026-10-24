<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex text-slate-200 bg-[#0B0F17]">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-h-screen">
        
        <main class="flex-1 p-8">
            @yield('content')
        </main>

        <!-- @include('partials.footer') -->
    </div>

</body>
</html>