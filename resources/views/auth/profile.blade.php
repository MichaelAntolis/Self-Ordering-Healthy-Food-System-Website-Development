<!-- auth/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body text-center p-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white fw-bold fs-3">{{ $customer->initials }}</span>
                    </div>
                    <h4 class="fw-bold text-dark">{{ $customer->name }}</h4>
                    <p class="text-muted mb-2">{{ $customer->email }}</p>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Bergabung {{ $customer->created_at->format('F Y') }}
                    </p>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-success mb-0">{{ $customer->total_orders }}</h5>
                                <small class="text-muted">Total Pesanan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-0">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</h5>
                            <small class="text-muted">Total Belanja</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nutrition Summary -->
            @if($customer->nutritionTracking)
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Ringkasan Nutrisi</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="fw-bold text-warning">{{ number_format($customer->nutritionTracking->total_calories, 0) }}</div>
                                <small class="text-muted">Kalori</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="fw-bold text-danger">{{ number_format($customer->nutritionTracking->total_protein, 1) }}g</div>
                                <small class="text-muted">Protein</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="fw-bold text-info">{{ number_format($customer->nutritionTracking->total_carbs, 1) }}g</div>
                                <small class="text-muted">Karbohidrat</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="fw-bold text-secondary">{{ number_format($customer->nutritionTracking->total_fat, 1) }}g</div>
                                <small class="text-muted">Lemak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-8">
            <!-- Update Profile Form -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <h6 class="text-success mb-3"><i class="fas fa-user me-2"></i>Informasi Pribadi</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label fw-semibold">Alamat</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       id="address" name="address" value="{{ old('address', $customer->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="allergies" class="form-label fw-semibold">Alergi Makanan</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror" 
                                      id="allergies" name="allergies" rows="2">{{ old('allergies', $customer->allergies) }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diet Preferences -->
                        <h6 class="text-success mb-3"><i class="fas fa-leaf me-2"></i>Preferensi Diet</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="diet_type" class="form-label fw-semibold">Jenis Diet</label>
                                <select class="form-select" id="diet_type" name="diet_type">
                                    <option value="">Pilih jenis diet</option>
                                    <option value="vegetarian" {{ old('diet_type', $customer->profile->diet_type ?? '') == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                    <option value="vegan" {{ old('diet_type', $customer->profile->diet_type ?? '') == 'vegan' ? 'selected' : '' }}>Vegan</option>
                                    <option value="keto" {{ old('diet_type', $customer->profile->diet_type ?? '') == 'keto' ? 'selected' : '' }}>Keto</option>
                                    <option value="paleo" {{ old('diet_type', $customer->profile->diet_type ?? '') == 'paleo' ? 'selected' : '' }}>Paleo</option>
                                    <option value="mediterranean" {{ old('diet_type', $customer->profile->diet_type ?? '') == 'mediterranean' ? 'selected' : '' }}>Mediterranean</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="low_carb" name="low_carb" value="1" 
                                           {{ old('low_carb', $customer->profile->low_carb ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="low_carb">
                                        Rendah Karbohidrat
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="high_protein" name="high_protein" value="1" 
                                           {{ old('high_protein', $customer->profile->high_protein ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="high_protein">
                                        Tinggi Protein
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="low_fat" name="low_fat" value="1" 
                                           {{ old('low_fat', $customer->profile->low_fat ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="low_fat">
                                        Rendah Lemak
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="gluten_free" name="gluten_free" value="1" 
                                           {{ old('gluten_free', $customer->profile->gluten_free ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gluten_free">
                                        Bebas Gluten
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="dairy_free" name="dairy_free" value="1" 
                                           {{ old('dairy_free', $customer->profile->dairy_free ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dairy_free">
                                        Bebas Dairy
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <h6 class="text-success mb-3 mt-4"><i class="fas fa-lock me-2"></i>Ubah Password</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-3">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Orders -->
            @if($recentOrders->count() > 0)
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Pesanan Terakhir</h5>
                </div>
                <div class="card-body">
                    @foreach($recentOrders as $order)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3 {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                        <div>
                            <h6 class="mb-1">{{ $order->order_number }}</h6>
                            <p class="text-muted small mb-1">
                                {{ $order->created_at->format('d M Y, H:i') }} • {{ $order->order_type_label }}
                            </p>
                            <div class="small text-muted">
                                {{ $order->foods->count() }} item(s) • 
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            <a href="{{ route('orders.status', $order) }}" class="btn btn-outline-success btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection