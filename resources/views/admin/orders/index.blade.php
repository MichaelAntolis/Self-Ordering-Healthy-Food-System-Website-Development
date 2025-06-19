<!-- admin/orders/index.blade.php -->
@extends('layouts.admin')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
    }
    
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .table-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    .action-btn {
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        margin: 0 2px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .order-number {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #495057;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <h1 class="mb-2">📋 Manajemen Pesanan</h1>
        <p class="mb-0 opacity-75">Kelola dan pantau semua pesanan pelanggan</p>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Daftar Pesanan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">No. Pesanan</th>
                        <th class="border-0 fw-bold">Pelanggan</th>
                        <th class="border-0 fw-bold">Tipe Pesanan</th>
                        <th class="border-0 fw-bold">Status</th>
                        <th class="border-0 fw-bold">Total</th>
                        <th class="border-0 fw-bold">Tanggal</th>
                        <th class="border-0 fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="border-0">
                            <span class="order-number">{{ $order->order_number }}</span>
                        </td>
                        <td class="border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $order->customer->name }}</div>
                                    <small class="text-muted">{{ $order->customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="border-0">
                            <span class="badge bg-info rounded-pill">{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</span>
                        </td>
                        <td class="border-0">
                            <span class="status-badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'primary' : 'danger')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="border-0">
                            <span class="fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="border-0">
                            <div>
                                <div class="fw-bold">{{ $order->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td class="border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info action-btn btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-warning action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $order->id }}" title="Edit Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach($orders as $order)

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $order->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editModalLabel{{ $order->id }}">
                                        <i class="fas fa-edit me-2"></i>Edit Order Status
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="editForm{{ $order->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="status{{ $order->id }}" class="form-label">Order Status</label>
                                            <select class="form-control" id="status{{ $order->id }}" name="status" required>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Order Details</label>
                                            <div class="border p-3 rounded bg-light">
                                                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                                <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
                                                <p><strong>Total Amount:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editConfirmationModal{{ $order->id }}">
                                            <i class="fas fa-save me-1"></i>Update Order
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Confirmation Modal -->
                    <div class="modal fade" id="editConfirmationModal{{ $order->id }}" tabindex="-1" aria-labelledby="editConfirmationModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editConfirmationModalLabel{{ $order->id }}">
                                        <i class="fas fa-question-circle me-2"></i>Confirm Update
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update this order status?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('editForm{{ $order->id }}').submit();">
                                        <i class="fas fa-check me-1"></i>Yes, Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $order->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the order <strong>{{ $order->order_number }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Section -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>

<script>
// Auto focus on status input when edit modal is shown
document.addEventListener('DOMContentLoaded', function() {
    @foreach($orders as $order)
        document.getElementById('editModal{{ $order->id }}').addEventListener('shown.bs.modal', function () {
            document.getElementById('status{{ $order->id }}').focus();
        });
    @endforeach
});
</script>
@endsection