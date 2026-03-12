@extends('pos::layouts.app')

@section('title', 'Detail Produk')
@section('header', 'Detail Produk')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h3>
            <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded mt-2 inline-block">
                {{ $product->category->name }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Harga</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Stok</p>
                <p class="text-2xl font-bold {{ $product->stock < 10 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $product->stock }} unit
                </p>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi</h4>
            <p class="text-gray-700">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('pos.products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('pos.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection

