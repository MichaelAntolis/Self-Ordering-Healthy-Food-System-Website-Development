<!-- checkout/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Review Pesanan Anda</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center border-bottom py-3 {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                        <div class="flex-shrink-0">
                            @if($item['food']->image)
                                <img src="{{ $item['food']->image_url }}" alt="{{ $item['food']->name }}" 
                                     class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $item['food']->name }}</h6>
                            <p class="text-muted small mb-1">{{ $item['food']->category->name }}</p>
                            <div class="small text-muted mb-1">
                                <span class="me-3"><i class="fas fa-fire text-warning"></i> {{ number_format($item['food']->calories * $item['quantity'], 0) }} kal</span>
                                <span class="me-3"><i class="fas fa-drumstick-bite text-danger"></i> {{ number_format($item['food']->protein * $item['quantity'], 1) }}g protein</span>
                            </div>
                            @if($item['customization'])
                                <div class="small text-info">
                                    <i class="fas fa-edit me-1"></i>{{ $item['customization'] }}
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">{{ $item['quantity'] }}x</div>
                            <div class="text-success fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Nutrition Summary -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-info text-white rounded-top-4">
                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Ringkasan Nutrisi</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-3">
                            <div class="text-center p-2 bg-warning bg-opacity-10 rounded">
                                <div class="fw-bold text-warning">{{ number_format($totalCalories, 0) }}</div>
                                <small class="text-muted">Kalori</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 bg-danger bg-opacity-10 rounded">
                                <div class="fw-bold text-danger">{{ number_format($totalProtein, 1) }}g</div>
                                <small class="text-muted">Protein</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 bg-info bg-opacity-10 rounded">
                                <div class="fw-bold text-info">{{ number_format($totalCarbs, 1) }}g</div>
                                <small class="text-muted">Karbohidrat</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 bg-secondary bg-opacity-10 rounded">
                                <div class="fw-bold text-secondary">{{ number_format($totalFat, 1) }}g</div>
                                <small class="text-muted">Lemak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Customer Information -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            {{ $customer->initials }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ $customer->name }}</div>
                            <div class="text-muted small">{{ $customer->email }}</div>
                        </div>
                    </div>
                    @if($customer->phone)
                        <div class="small text-muted mb-1">
                            <i class="fas fa-phone me-2"></i>{{ $customer->phone }}
                        </div>
                    @endif
                    @if($customer->address)
                        <div class="small text-muted mb-1">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $customer->address }}
                        </div>
                    @endif
                    @if($customer->allergies)
                        <div class="small text-warning mt-2">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Alergi:</strong> {{ $customer->allergies }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Form -->
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Detail Pesanan</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="order_type" class="form-label fw-semibold">Jenis Pesanan</label>
                            <select class="form-select @error('order_type') is-invalid @enderror" 
                                    id="order_type" name="order_type" required>
                                <option value="">Pilih jenis pesanan</option>
                                <option value="dine_in" {{ old('order_type') == 'dine_in' ? 'selected' : '' }}>
                                    Makan di Tempat
                                </option>
                                <option value="take_away" {{ old('order_type') == 'take_away' ? 'selected' : '' }}>
                                    Bawa Pulang
                                </option>
                            </select>
                            @error('order_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" name="payment_method" required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>
                                    QRIS
                                </option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>
                                    Kartu Kredit
                                </option>
                                <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>
                                    Kartu Debit
                                </option>
                                <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>
                                    E-Wallet
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="special_requests" class="form-label fw-semibold">Permintaan Khusus <span class="text-muted">(Opsional)</span></label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                      id="special_requests" name="special_requests" rows="3" 
                                      placeholder="Tambahkan catatan khusus untuk pesanan Anda">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Summary -->
                        <div class="border-top pt-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Item:</span>
                                <span>{{ count($cartItems) }} item</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5 text-success">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-3">
                                <i class="fas fa-check me-2"></i>Buat Pesanan
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection