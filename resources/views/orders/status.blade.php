<!-- orders/status.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-receipt text-success me-2"></i>Detail Pesanan
                </h2>
                <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Order Status Card -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1 fw-bold">{{ $order->order_number }}</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d M Y, H:i') }} • 
                                <i class="fas fa-{{ $order->order_type == 'dine_in' ? 'utensils' : 'shopping-bag' }} me-1"></i>{{ $order->order_type_label }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : ($order->status == 'processing' ? 'warning' : 'info')) }} fs-5 px-4 py-2">
                                <i class="fas fa-{{ $order->status == 'completed' ? 'check-circle' : ($order->status == 'cancelled' ? 'times-circle' : ($order->status == 'processing' ? 'clock' : 'hourglass-half')) }} me-2"></i>
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Progress -->
            @if($order->status != 'cancelled')
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-tasks text-success me-2"></i>Status Pesanan
                    </h6>
                    <div class="progress-container">
                        <div class="d-flex justify-content-between position-relative">
                            <!-- Progress Line -->
                            <div class="progress-line position-absolute" style="top: 15px; left: 15px; right: 15px; height: 2px; background: #e9ecef; z-index: 1;">
                                <div class="progress-fill" style="height: 100%; background: #28a745; width: {{ $order->status == 'pending' ? '25%' : ($order->status == 'processing' ? '75%' : '100%') }}; transition: width 0.3s ease;"></div>
                            </div>
                            
                            <!-- Step 1: Pending -->
                            <div class="text-center position-relative" style="z-index: 2;">
                                <div class="step-circle {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'completed' ? 'active' : '' }}" style="width: 30px; height: 30px; border-radius: 50%; background: {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'completed' ? '#28a745' : '#e9ecef' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-hourglass-half text-white" style="font-size: 12px;"></i>
                                </div>
                                <small class="d-block mt-2 {{ $order->status == 'pending' ? 'text-success fw-bold' : 'text-muted' }}">Menunggu</small>
                            </div>
                            
                            <!-- Step 2: Processing -->
                            <div class="text-center position-relative" style="z-index: 2;">
                                <div class="step-circle {{ $order->status == 'processing' || $order->status == 'completed' ? 'active' : '' }}" style="width: 30px; height: 30px; border-radius: 50%; background: {{ $order->status == 'processing' || $order->status == 'completed' ? '#28a745' : '#e9ecef' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-clock text-white" style="font-size: 12px;"></i>
                                </div>
                                <small class="d-block mt-2 {{ $order->status == 'processing' ? 'text-success fw-bold' : 'text-muted' }}">Diproses</small>
                            </div>
                            
                            <!-- Step 3: Completed -->
                            <div class="text-center position-relative" style="z-index: 2;">
                                <div class="step-circle {{ $order->status == 'completed' ? 'active' : '' }}" style="width: 30px; height: 30px; border-radius: 50%; background: {{ $order->status == 'completed' ? '#28a745' : '#e9ecef' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-check-circle text-white" style="font-size: 12px;"></i>
                                </div>
                                <small class="d-block mt-2 {{ $order->status == 'completed' ? 'text-success fw-bold' : 'text-muted' }}">Selesai</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Message -->
                    <div class="mt-4 p-3 rounded" style="background: {{ $order->status == 'completed' ? '#d4edda' : ($order->status == 'processing' ? '#fff3cd' : '#cce7ff') }}; border-left: 4px solid {{ $order->status == 'completed' ? '#28a745' : ($order->status == 'processing' ? '#ffc107' : '#007bff') }};">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-{{ $order->status == 'completed' ? 'check-circle text-success' : ($order->status == 'processing' ? 'clock text-warning' : 'info-circle text-info') }} me-2"></i>
                            <span class="fw-medium">
                                @if($order->status == 'completed')
                                    Pesanan Anda telah selesai dan siap untuk dinikmati!
                                @elseif($order->status == 'processing')
                                    Pesanan Anda sedang diproses oleh dapur kami.
                                @else
                                    Pesanan Anda telah diterima dan menunggu untuk diproses.
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Order Items -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-utensils text-success me-2"></i>Item Pesanan
                    </h6>
                    <div class="order-items">
                        @foreach($order->foods as $food)
                        <div class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                     <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                 </div>
                                <div>
                                    <h6 class="mb-1">{{ $food->name }}</h6>
                                    <small class="text-muted">{{ $food->pivot->quantity }}x @ Rp {{ number_format($food->pivot->price, 0, ',', '.') }}</small>
                                    @if($food->pivot->customization)
                                    <br><small class="text-info"><i class="fas fa-edit me-1"></i>{{ $food->pivot->customization }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-success">Rp {{ number_format($food->pivot->price * $food->pivot->quantity, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-calculator text-success me-2"></i>Ringkasan Pesanan
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Pajak & Biaya:</span>
                                <span>Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold text-success fs-5">
                                <span>Total:</span>
                                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded p-3">
                                <div class="small text-muted mb-2">
                                    <i class="fas fa-utensils me-1"></i>{{ $order->foods->count() }} item • 
                                    <i class="fas fa-fire text-warning me-1"></i>{{ number_format($order->getTotalCalories(), 0) }} kalori
                                </div>
                                @if($order->special_requests)
                                <div class="small">
                                    <i class="fas fa-comment text-info me-1"></i>
                                    <strong>Catatan:</strong> {{ $order->special_requests }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            @if($order->payment)
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-credit-card text-success me-2"></i>Informasi Pembayaran
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Metode Pembayaran:</span>
                                <span class="fw-medium">{{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Status Pembayaran:</span>
                                <span class="badge bg-{{ $order->payment->status == 'completed' ? 'success' : ($order->payment->status == 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Jumlah Dibayar:</span>
                                <span class="fw-bold text-success">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                            </div>
                            @if($order->payment->paid_at)
                            <div class="d-flex justify-content-between">
                                <span>Tanggal Bayar:</span>
                                <span>{{ $order->payment->paid_at->format('d M Y, H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                             @if($order->status == 'pending')
                             <button type="button" class="btn btn-outline-danger me-2" onclick="cancelOrder({{ $order->id }})">
                                 <i class="fas fa-times me-2"></i>Batalkan Pesanan
                             </button>
                             @elseif($order->status == 'processing')
                             <button type="button" class="btn btn-outline-secondary me-2" disabled>
                                 <i class="fas fa-ban me-2"></i>Tidak Dapat Dibatalkan
                             </button>
                             <div class="mt-1">
                                 <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Pesanan sedang diproses dan tidak dapat dibatalkan</small>
                             </div>
                             @endif
                         </div>
                        <div>
                            @if($order->isCompleted())
                            <a href="{{ route('menu') }}" class="btn btn-success me-2">
                                <i class="fas fa-redo me-2"></i>Pesan Lagi
                            </a>
                            @endif
                            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i>Lihat Semua Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cancelOrder(orderId) {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        // Add cancel order logic here
        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal membatalkan pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
@endpush
@endsection