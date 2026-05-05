<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white flex flex-col z-30">
        <div class="h-16 flex items-center px-6 border-b border-gray-700">
            <span class="text-lg font-semibold tracking-tight">AutoParts ERP</span>
        </div>
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @php $nav = [
                ['route' => 'admin.dashboard',      'label' => 'Dashboard',    'icon' => '📊'],
                ['route' => 'admin.products.index', 'label' => 'Products',     'icon' => '🔧'],
                ['route' => 'admin.orders.index',   'label' => 'Orders',       'icon' => '📦'],
                ['route' => 'admin.purchases.index','label' => 'Purchases',    'icon' => '🛒'],
                ['route' => 'admin.suppliers.index','label' => 'Suppliers',    'icon' => '🏭'],
                ['route' => 'admin.categories.index','label' => 'Categories',  'icon' => '📂'],
                ['route' => 'admin.brands.index',   'label' => 'Brands',       'icon' => '🏷️'],
                ['route' => 'admin.cars.index',     'label' => 'Cars',         'icon' => '🚗'],
                ['route' => 'admin.admins.index',   'label' => 'Admins',       'icon' => '👤'],
                ['route' => 'admin.settings',       'label' => 'Settings',     'icon' => '⚙️'],
                ['route' => 'admin.reports',        'label' => 'Reports',      'icon' => '📈'],
            ] @endphp

            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs($item['route'] . '*')
                              ? 'bg-teal-600 text-white'
                              : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="px-4 py-4 border-t border-gray-700">
            <p class="text-xs text-gray-400 mb-2">{{ auth('admin')->user()->name }}</p>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left text-sm text-red-400 hover:text-red-300 transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="ml-64 min-h-screen flex flex-col">
        {{-- Top Bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 sticky top-0 z-20">
            <h1 class="text-base font-semibold text-gray-800">@yield('heading', 'Dashboard')</h1>
            <div class="ml-auto flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ now()->format('D, M j Y') }}</span>
            </div>
        </header>

        <div class="flex-1 p-6">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>