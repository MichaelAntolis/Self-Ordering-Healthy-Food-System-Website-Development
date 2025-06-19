<!-- orders/history.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-history text-success me-2"></i>Riwayat Pesanan
                </h2>
                <a href="{{ route('menu') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Pesan Lagi
                </a>
            </div>

            @if($orders->count() > 0)
            @foreach($orders as $order)
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $order->order_number }}</h5>
                            <p class="text-muted mb-0">
                                {{ $order->created_at->format('d M Y, H:i') }} • {{ $order->order_type_label }}
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : ($order->status == 'processing' ? 'warning' : 'info')) }} fs-6 px-3 py-2">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($order->foods->take(3) as $food)
                                <div class="d-flex align-items-center bg-light rounded px-2 py-1">
                                    <span class="small">{{ $food->pivot->quantity }}x {{ $food->name }}</span>
                                </div>
                                @endforeach
                                @if($order->foods->count() > 3)
                                <div class="d-flex align-items-center bg-light rounded px-2 py-1">
                                    <span class="small text-muted">+{{ $order->foods->count() - 3 }} item lagi</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <div class="fw-bold text-success fs-5">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    @if($order->payment)
                    <div class="small text-muted mb-3">
                        <i class="fas fa-credit-card me-1"></i>
                        {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }} •
                        <span class="badge bg-{{ $order->payment->status == 'completed' ? 'success' : ($order->payment->status == 'failed' ? 'danger' : 'warning') }} badge-sm">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @endif

                    <!-- Special Requests -->
                    @if($order->special_requests)
                    <div class="small text-muted mb-3">
                        <i class="fas fa-comment me-1"></i>
                        <strong>Catatan:</strong> {{ $order->special_requests }}
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-utensils me-1"></i>{{ $order->foods->count() }} item •
                            <i class="fas fa-fire text-warning me-1"></i>{{ number_format($order->getTotalCalories(), 0) }} kalori
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('orders.status', $order) }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            @if($order->canBeCancelled())
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="cancelOrder({{ $order->id }})">
                                <i class="fas fa-times me-1"></i>Batalkan
                            </button>
                            @endif
                            @if($order->isCompleted())
                            <a href="{{ route('menu') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-redo me-1"></i>Pesan Lagi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted mb-3">Belum Ada Pesanan</h4>
                <p class="text-muted mb-4">Anda belum pernah melakukan pesanan. Mulai jelajahi menu kami!</p>
                <a href="{{ route('menu') }}" class="btn btn-success btn-lg rounded-3">
                    <i class="fas fa-utensils me-2"></i>Lihat Menu
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Batalkan Pesanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                <p class="text-muted small">Pesanan yang sudah dibatalkan tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <form id="cancelOrderForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function cancelOrder(orderId) {
        const form = document.getElementById('cancelOrderForm');
        form.action = `/orders/${orderId}/cancel`;

        const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
        modal.show();
    }
</script>
@endpush
@endsection