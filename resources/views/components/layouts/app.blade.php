<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Headless CMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <!-- Sidebar toggle button -->
    <button data-drawer-target="admin-sidebar" data-drawer-toggle="admin-sidebar" aria-controls="admin-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside id="admin-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0"
        aria-label="Admin Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
            <div class="px-4 py-2 mb-4">
                <h1 class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Headless CMS') }}</h1>
            </div>
            <ul class="space-y-2 font-medium">
                <li>
                    @permission('view_posts')
                        <a href="{{ route('posts.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <span class="ms-3">Posts</span>
                        </a>
                    @endpermission
                </li>

                <li>
                    @permission('view_categories')
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <span class="ms-3">Categories</span>
                        </a>
                    @endpermission
                </li>
                <li>
                    @permission('view_pages')
                        <a href="{{ route('pages.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <span class="ms-3">Pages</span>
                        </a>
                    @endpermission
                </li>
                <li>
                    @permission('view_users')
                        <a href="{{ route('users.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <span class="ms-3">Users</span>
                        </a>
                    @endpermission
                </li>
                <li>
                    @permission('manage_permissions')
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <span class="ms-3">Role</span>
                        </a>
                    @endpermission
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                        <span class="ms-3">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main content -->
    <div class="p-4 md:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
            {{ $slot }}
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>

</html>
