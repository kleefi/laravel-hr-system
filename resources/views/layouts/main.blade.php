<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HR Simple System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-navbar />
    @hasrole('admin')
    <x-sidebar-admin />
    @elserole('employee')
    <x-sidebar-user />
    @endhasrole
    <div class="p-8 mt-16 sm:ml-64">
        @yield('content')
    </div>
    @yield('scripts')

</body>
<script src="https://unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</html>