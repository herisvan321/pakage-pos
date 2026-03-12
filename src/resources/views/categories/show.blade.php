@extends('pos::layouts.app')

@section('title', 'Detail Kategori')
@section('header', 'Detail Kategori')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h3>
            <p class="text-gray-600 mt-1">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
        </div>

        <div class="mb-6">
            <h4 class="text-sm font-medium text-gray-500 mb-3">Produk dalam kategori ini:</h4>
            @if($category->products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($category->products as $product)
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="font-medium text-gray-800">{{ $product->name }}</p>
                    <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }} | Stok: {{ $product->stock }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500">Belum ada produk</p>
            @endif
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('pos.categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('pos.categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection

