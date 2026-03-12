@extends('pos::layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <i class="fas fa-box text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Kategori</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalCategories }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-tags text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Penjualan Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Penjualan</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-orange-100 p-4 rounded-full">
                <i class="fas fa-money-bill-wave text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Sales -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-history mr-2"></i>Penjualan Terbaru
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-2 text-sm font-medium text-gray-500">ID</th>
                        <th class="text-left py-3 px-2 text-sm font-medium text-gray-500">Tanggal</th>
                        <th class="text-right py-3 px-2 text-sm font-medium text-gray-500">Total</th>
                        <th class="text-left py-3 px-2 text-sm font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-2">#{{ $sale->id }}</td>
                        <td class="py-3 px-2">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-2 text-right">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                        <td class="py-3 px-2">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                {{ $sale->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Belum ada penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>Stok Menipis
        </h3>
        <div class="space-y-3">
            @forelse($lowStockProducts as $product)
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-box text-red-500"></i>
                    <div>
                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                    </div>
                </div>
                <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded">
                    {{ $product->stock }} unit
                </span>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">
                <i class="fas fa-check-circle text-4xl text-green-500 mb-2"></i>
                <p>Stok produk aman</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

