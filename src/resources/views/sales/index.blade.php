@extends('pos::layouts.app')

@section('title', 'Penjualan')
@section('header', 'Manajemen Penjualan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('pos.sales.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Penjualan Baru
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Penjualan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($sales as $sale)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">#{{ $sale->id }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $sale->user->name }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded">
                        {{ $sale->status }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('pos.sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $sales->links() }}
</div>
@endsection

