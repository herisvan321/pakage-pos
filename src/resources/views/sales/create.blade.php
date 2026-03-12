@extends('pos::layouts.app')

@section('title', 'Penjualan Baru')
@section('header', 'Penjualan Baru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Product Selection -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Produk</h3>
            
            <div class="mb-4">
                <input type="text" id="searchProduct" placeholder="Cari produk..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="productList">
                @foreach($products as $product)
                <div class="product-item border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition"
                    data-id="{{ $product->id }}" data-name="{{ $product->name }}" 
                    data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                    <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-blue-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-500">Stok: {{ $product->stock }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Keranjang</h3>
        
        <form action="{{ route('pos.sales.store') }}" method="POST" id="saleForm">
            @csrf
            <div id="cartItems" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                <p class="text-gray-500 text-center py-4">Keranjang kosong</p>
            </div>
            
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Total:</span>
                    <span class="text-2xl font-bold text-gray-800" id="cartTotal">Rp 0</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg mt-4" id="btnSubmit" disabled>
                <i class="fas fa-check mr-2"></i>Simpan Penjualan
            </button>
            
            <a href="{{ route('pos.sales.index') }}" class="block text-center mt-3 text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </form>
    </div>
</div>

@push('scripts')
<script>
let cart = [];

function updateCart() {
    const cartContainer = document.getElementById('cartItems');
    const totalElement = document.getElementById('cartTotal');
    const submitBtn = document.getElementById('btnSubmit');
    
    if (cart.length === 0) {
        cartContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Keranjang kosong</p>';
        totalElement.textContent = 'Rp 0';
        submitBtn.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    cart.forEach((item, index) => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        html += `
            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                <div>
                    <p class="font-medium text-gray-800">${item.name}</p>
                    <p class="text-sm text-gray-500">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="font-semibold">Rp ${subtotal.toLocaleString('id-ID')}</span>
                    <button type="button" onclick="removeFromCart(${index})" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            </div>
        `;
    });

    cartContainer.innerHTML = html;
    totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
    submitBtn.disabled = false;
}

function addToCart(id, name, price, stock) {
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        if (existingItem.quantity < stock) {
            existingItem.quantity++;
        } else {
            alert('Stok tidak cukup!');
            return;
        }
    } else {
        cart.push({ id, name, price, quantity: 1, stock });
    }
    
    updateCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

// Product click handler
document.querySelectorAll('.product-item').forEach(item => {
    item.addEventListener('click', () => {
        addToCart(
            item.dataset.id,
            item.dataset.name,
            parseFloat(item.dataset.price),
            parseInt(item.dataset.stock)
        );
    });
});

// Search functionality
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item => {
        const name = item.dataset.name.toLowerCase();
        item.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
});
</script>
@endpush
@endsection

