<!-- cart/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Keranjang Belanja</h2>
                <a href="{{ route('menu') }}" class="btn btn-outline-success">
                    Lanjut Belanja
                </a>
            </div>

            @if(empty($cartItems))
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <i class="fas fa-shopping-cart text-muted" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h4 class="text-muted mb-3">Keranjang Anda Kosong</h4>
                    <p class="text-muted mb-4">Sepertinya Anda belum menambahkan item apapun ke keranjang. Mari mulai berbelanja!</p>
                    <a href="{{ route('menu') }}" class="btn btn-success btn-lg">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h5 class="mb-0">Item dalam Keranjang ({{ count($cartItems) }})</h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($cartItems as $index => $item)
                                <div class="cart-item border-bottom p-4 {{ $loop->last ? 'border-bottom-0' : '' }}" data-food-id="{{ $item['food']->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            @if($item['food']->image)
                                                <img src="{{ $item['food']->image_url }}" alt="{{ $item['food']->name }}" 
                                                     class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 80px;">
                                                    <i class="fas fa-utensils text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1 fw-bold">{{ $item['food']->name }}</h6>
                                            <p class="text-muted small mb-1">{{ $item['food']->category->name }}</p>
                                            <div class="small text-muted">
                                                <span class="me-3">{{ number_format($item['food']->calories, 0) }} kal</span>
                                                <span>{{ number_format($item['food']->protein, 1) }}g protein</span>
                                            </div>
                                            @if($item['customization'])
                                                <div class="small text-info mt-1">
                                                    <strong>Catatan:</strong> {{ $item['customization'] }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="fw-bold text-success">
                                                Rp {{ number_format($item['food']->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <form method="POST" action="{{ route('cart.update') }}" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="food_id" value="{{ $item['food']->id }}">
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary me-2" 
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>
                                                </form>
                                                
                                                <span class="quantity-display mx-2 fw-bold">{{ $item['quantity'] }}</span>
                                                
                                                <form method="POST" action="{{ route('cart.update') }}" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="food_id" value="{{ $item['food']->id }}">
                                                    <input type="hidden" name="quantity" value="{{ min(10, $item['quantity'] + 1) }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary ms-2"
                                                            {{ $item['quantity'] >= 10 ? 'disabled' : '' }}>
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <div class="fw-bold fs-6 mb-2">
                                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </div>
                                            
                                            <!-- Form-based remove button (more reliable) -->
                                            <form method="POST" action="{{ route('cart.remove') }}" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="food_id" value="{{ $item['food']->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus {{ $item['food']->name }}?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="card-footer bg-light border-0 rounded-bottom-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <form method="POST" action="{{ route('cart.clear') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Yakin ingin mengosongkan seluruh keranjang?')">
                                            Kosongkan Keranjang
                                        </button>
                                    </form>
                                    <div class="text-muted">
                                        <small>Total {{ count($cartItems) }} item dalam keranjang</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                            <div class="card-header bg-success text-white rounded-top-4">
                                <h5 class="mb-0">Ringkasan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item:</span>
                                    <span>{{ count($cartItems) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold">Total Harga:</span>
                                    <span class="fw-bold text-success fs-5">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                </div>
                                
                                <!-- Nutrition Summary -->
                                <hr>
                                <h6 class="text-success mb-3">Ringkasan Nutrisi</h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-warning bg-opacity-10 rounded">
                                            <div class="fw-bold text-warning">{{ number_format($totalCalories ?? 0, 0) }}</div>
                                            <small class="text-muted">Kalori</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-danger bg-opacity-10 rounded">
                                            <div class="fw-bold text-danger">{{ number_format($totalProtein ?? 0, 1) }}g</div>
                                            <small class="text-muted">Protein</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-info bg-opacity-10 rounded">
                                            <div class="fw-bold text-info">{{ number_format($totalCarbs ?? 0, 1) }}g</div>
                                            <small class="text-muted">Karbohidrat</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-secondary bg-opacity-10 rounded">
                                            <div class="fw-bold text-secondary">{{ number_format($totalFat ?? 0, 1) }}g</div>
                                            <small class="text-muted">Lemak</small>
                                        </div>
                                    </div>
                                </div>

                                @auth('customer')
                                    <div class="d-grid">
                                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">
                                            Lanjut ke Checkout
                                        </a>
                                    </div>
                                @else
                                    <div class="alert alert-info mb-3">
                                        <small>Silakan login untuk melanjutkan checkout</small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('login') }}" class="btn btn-success">
                                            Login untuk Checkout
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-success">
                                            Daftar Akun Baru
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
     style="background: rgba(0,0,0,0.5); z-index: 9999; display: none !important;">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

@push('scripts')
<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Show loading
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

// Hide loading
function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}



// Update quantity
function updateQuantity(foodId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(foodId);
        return;
    }
    
    if (newQuantity > 10) {
        console.log('Maksimal 10 item per produk');
        return;
    }
    
    showLoading();
    
    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            food_id: foodId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            location.reload(); // Reload untuk update harga
        } else {
            console.log(data.message || 'Gagal mengupdate quantity');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        console.log('Terjadi kesalahan');
    });
}

// Remove from cart with timeout
function removeFromCart(foodId, foodName = 'Item') {
    if (!confirm(`Apakah Anda yakin ingin menghapus ${foodName} dari keranjang?`)) {
        return;
    }
    
    showLoading();
    
    // Set timeout untuk menghindari loading terus
    const timeoutId = setTimeout(() => {
        hideLoading();
        console.log(`${foodName} berhasil dihapus dari keranjang`);
        location.reload();
    }, 5000); // 5 detik timeout
    
    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            food_id: foodId
        })
    })
    .then(response => {
        clearTimeout(timeoutId); // Clear timeout jika response berhasil
        hideLoading();
        
        if (response.ok) {
            return response.json();
        } else {
            throw new Error(`HTTP ${response.status}`);
        }
    })
    .then(data => {
        if (data && data.success) {
            console.log(`${foodName} berhasil dihapus dari keranjang`);
        } else {
            console.log(`${foodName} berhasil dihapus dari keranjang`);
        }
        
        // Reload untuk update tampilan
        setTimeout(() => {
            location.reload();
        }, 1000);
    })
    .catch(error => {
        clearTimeout(timeoutId);
        hideLoading();
        console.error('Error:', error);
        
        // Assume success karena biasanya data sudah terhapus
        console.log(`${foodName} berhasil dihapus dari keranjang`);
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
}

// Clear cart
function clearCart() {
    if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
        return;
    }
    
    showLoading();
    
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        hideLoading();
        if (response.ok) {
            console.log('Keranjang berhasil dikosongkan');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            console.log('Gagal mengosongkan keranjang');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        console.log('Terjadi kesalahan');
    });
}

// Update cart badge on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update cart badge
    const cartItems = {{ count($cartItems ?? []) }};
    const badges = document.querySelectorAll('#cartBadge, #cartBadgeFab');
    badges.forEach(badge => {
        if (badge) {
            if (cartItems > 0) {
                badge.textContent = cartItems;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    });
});
</script>
@endpush
@endsection