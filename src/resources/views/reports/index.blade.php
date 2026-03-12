@extends('pos::layouts.app')

@section('title', 'Laporan')
@section('header', 'Laporan Penjualan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('pos.reports.daily') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-100 p-4 rounded-full">
                <i class="fas fa-calendar-day text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Laporan Harian</h3>
                <p class="text-gray-500 text-sm">Lihat penjualan per hari</p>
            </div>
        </div>
    </a>

    <a href="{{ route('pos.reports.monthly') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition">
        <div class="flex items-center space-x-4">
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Laporan Bulanan</h3>
                <p class="text-gray-500 text-sm">Lihat penjualan per bulan</p>
            </div>
        </div>
    </a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center space-x-4">
            <div class="bg-purple-100 p-4 rounded-full">
                <i class="fas fa-chart-pie text-purple-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Semua Penjualan</h3>
                <p class="text-gray-500 text-sm">{{ $sales->count() }} transaksi</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Riwayat Penjualan</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($sales as $sale)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">#{{ $sale->id }}</td>
                <td class="px-6 py-4">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4">{{ $sale->user->name }}</td>
                <td class="px-6 py-4 font-semibold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded">
                        {{ $sale->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada penjualan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $sales->links() }}
</div>
@endsection

