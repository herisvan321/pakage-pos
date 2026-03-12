@extends('pos::layouts.app')

@section('title', 'Detail Penjualan')
@section('header', 'Detail Penjualan')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Penjualan #{{ $sale->id }}</h3>
                <p class="text-gray-500">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <span class="bg-green-100 text-green-800 text-sm px-4 py-2 rounded-lg">
                {{ $sale->status }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Kasir</p>
                <p class="font-semibold text-gray-800">{{ $sale->user->name }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Items</h4>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Produk</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Harga</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Jumlah</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($sale->items as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->product->name }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-semibold">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-lg">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('pos.sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('pos.sales.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Penjualan Baru
            </a>
        </div>
    </div>
</div>
@endsection

