@extends('pos::layouts.app')

@section('title', 'Laporan Harian')
@section('header', 'Laporan Penjualan Harian')

@section('content')
<div class="mb-6">
    <form action="{{ route('pos.reports.daily') }}" method="GET" class="flex items-center space-x-4">
        <div>
            <label class="text-sm text-gray-600">Pilih Tanggal:</label>
            <input type="date" name="date" value="{{ $date }}" 
                class="ml-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        <a href="{{ route('pos.reports.daily') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Hari Ini
        </a>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Total Pendapatan</p>
        <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Total Transaksi</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-sm">Rata-rata per Transaksi</p>
        <p class="text-3xl font-bold text-gray-800">
            Rp {{ number_format($totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0, 0, ',', '.') }}
        </p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">
            Penjualan Tanggal {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
        </h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($sales as $sale)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">#{{ $sale->id }}</td>
                <td class="px-6 py-4">{{ $sale->created_at->format('H:i') }}</td>
                <td class="px-6 py-4">{{ $sale->user->name }}</td>
                <td class="px-6 py-4 font-semibold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('pos.sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada penjualan pada tanggal ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 flex justify-between">
    <a href="{{ route('pos.reports.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>
@endsection

