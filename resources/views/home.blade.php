<!-- home.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Selamat Datang di <span class="text-success">Healthy</span>Order
                </h1>
                <p class="lead mb-4">
                    Pesan makanan sehat dengan mudah dan praktis. Dapatkan nutrisi terbaik untuk gaya hidup sehat Anda.
                </p>
                <div class="d-flex gap-3 mb-4">
                    <a href="{{ route('menu') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-utensils me-2"></i>Lihat Menu
                    </a>
                    @auth('customer')
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-history me-2"></i>Riwayat Pesanan
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{asset('images/tes.png')}}"
                    alt="Healthy Food" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</section>

@auth('customer')
<!-- Quick Actions untuk User yang Login -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Hai, {{ Auth::guard('customer')->user()->name }}!</h5>
                                <p class="text-muted mb-0">Apa yang ingin Anda lakukan hari ini?</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user me-1"></i>Profile
                                </a>
                                <a href="{{ route('orders.history') }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-history me-1"></i>Riwayat
                                </a>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-warning btn-sm position-relative">
                                    <i class="fas fa-shopping-cart me-1"></i>Keranjang
                                    <span class="cart-badge" id="cartBadgeQuick" style="display: none;">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endauth

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Mengapa Memilih HealthyOrder?</h2>
            <p class="text-muted">Dapatkan pengalaman terbaik dalam memesan makanan sehat</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-leaf text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">100% Organic</h5>
                        <p class="text-muted">Semua bahan makanan dipilih dari sumber organik terbaik untuk kesehatan optimal Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-chart-line text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Tracking Nutrisi</h5>
                        <p class="text-muted">Pantau asupan kalori, protein, karbohidrat, dan lemak Anda secara real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-clock text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Pesan Cepat</h5>
                        <p class="text-muted">Sistem pemesanan yang mudah dan cepat, siap dalam hitungan menit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Foods -->
@if($featuredFoods->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Menu Unggulan</h2>
            <a href="{{ route('menu') }}" class="btn btn-success">
                Lihat Semua Menu <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredFoods as $food)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        @if($food->image)
                        <img src="{{ $food->image_url }}" class="card-img-top menu-item-image" alt="{{ $food->name }}">
                        @else
                        <div class="menu-item-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-utensils text-muted fa-3x"></i>
                        </div>
                        @endif

                        @if($food->is_vegetarian)
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">
                            <i class="fas fa-leaf"></i> Vegetarian
                        </span>
                        @endif

                        @if($food->is_low_calorie)
                        <span class="badge bg-info position-absolute top-0 end-0 m-2">
                            <i class="fas fa-fire"></i> Low Cal
                        </span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-1">{{ $food->name }}</h5>
                            <span class="badge bg-light text-dark">{{ $food->category->name }}</span>
                        </div>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($food->description, 100) }}</p>

                        <div class="row g-2 mb-3 small">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fire text-warning me-1"></i>
                                    <span>{{ number_format($food->calories, 0) }} kal</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-drumstick-bite text-danger me-1"></i>
                                    <span>{{ number_format($food->protein, 1) }}g protein</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-success fs-5">
                                Rp {{ number_format($food->price, 0, ',', '.') }}
                            </div>
                            <a href="{{ route('menu.show', $food) }}" class="btn btn-success btn-sm">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Kategori Makanan</h2>
            <p class="text-muted">Temukan makanan sehat berdasarkan kategori favorit Anda</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('menu', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-utensils text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="fw-bold text-dark">{{ $category->name }}</h5>
                            <p class="text-muted small">{{ $category->description ?? 'Lihat berbagai pilihan makanan sehat' }}</p>
                            <div class="mt-3">
                                <span class="btn btn-success btn-sm">
                                    Lihat Menu <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-success text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Siap Memulai Hidup Sehat?</h2>
        <p class="lead mb-4">Bergabunglah dengan ribuan orang yang telah merasakan manfaat makanan sehat dari HealthyOrder</p>
        @guest('customer')
        <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
            <i class="fas fa-user-plus me-2"></i>Daftar Gratis
        </a>
        @endguest
        <a href="{{ route('menu') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-utensils me-2"></i>Pesan Sekarang
        </a>
    </div>
</section>

@push('scripts')
<script>
    function addToCartQuick(foodId, foodName) {
        fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    food_id: foodId,
                    quantity: 1,
                    customization: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge
                    updateCartBadge();
                } else {
                    console.log('Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                console.log('Terjadi kesalahan');
            });
    }



    // Update cart badge on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();

        // Update quick cart badge as well
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const quickBadge = document.getElementById('cartBadgeQuick');
                if (quickBadge && data.count > 0) {
                    quickBadge.textContent = data.count;
                    quickBadge.style.display = 'flex';
                }
            });
    });
</script>
@endpush
@endsection