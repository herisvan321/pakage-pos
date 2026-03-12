<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Application')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100">
    @auth
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 text-center border-b border-gray-700">
                <h1 class="text-2xl font-bold">POS App</h1>
                <p class="text-gray-400 text-sm">Point of Sales</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('pos.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('pos.dashboard') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('pos.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('pos.categories.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span>Kategori</span>
                </a>
                
                <a href="{{ route('pos.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('pos.products.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span>Produk</span>
                </a>
                
                <a href="{{ route('pos.sales.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('pos.sales.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>Penjualan</span>
                </a>
                
                <a href="{{ route('pos.reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('pos.reports.*') ? 'bg-gray-800' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Laporan</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-700">
                <form action="{{ route('pos.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 bg-red-700">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->roles->count() > 0)
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ auth()->user()->roles->first()->name }}
                    </span>
                    @endif
                </div>
            </header>
            
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
    @else
    @yield('guest-content')
    @endauth
    
    @stack('scripts')
</body>
</html>

