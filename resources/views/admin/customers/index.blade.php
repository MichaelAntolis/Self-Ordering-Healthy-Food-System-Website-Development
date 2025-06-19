<!-- admin/customers/index.blade.php -->
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
    
    .create-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 15px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .create-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        color: white;
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
    
    .customer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .orders-badge {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .allergy-tag {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
        border-radius: 15px;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        margin: 0.125rem;
        display: inline-block;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">👥 Manajemen Pelanggan</h1>
                <p class="mb-0 opacity-75">Kelola data pelanggan dan riwayat pesanan</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="create-btn text-decoration-none">
                <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i>Daftar Pelanggan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Avatar</th>
                        <th class="border-0 fw-bold">Nama</th>
                        <th class="border-0 fw-bold">Kontak</th>
                        <th class="border-0 fw-bold">Alamat</th>
                        <th class="border-0 fw-bold">Alergi</th>
                        <th class="border-0 fw-bold">Total Pesanan</th>
                        <th class="border-0 fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td class="border-0">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </div>
                        </td>
                        <td class="border-0">
                            <div class="fw-bold">{{ $customer->name }}</div>
                            <small class="text-muted">{{ $customer->email }}</small>
                        </td>
                        <td class="border-0">
                            <div class="text-muted">
                                <i class="fas fa-phone me-1"></i>{{ $customer->phone }}
                            </div>
                        </td>
                        <td class="border-0">
                            <span class="text-muted">{{ Str::limit($customer->address, 30) }}</span>
                        </td>
                        <td class="border-0">
                            @if($customer->allergies)
                                @foreach(explode(',', $customer->allergies) as $allergy)
                                    <span class="allergy-tag">{{ trim($allergy) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="border-0">
                            <span class="orders-badge">{{ $customer->orders_count }} pesanan</span>
                        </td>
                        <td class="border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-info action-btn btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-warning action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $customer->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $customer->id }}" title="Hapus">
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

    @foreach($customers as $customer)

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editModalLabel{{ $customer->id }}">
                                        <i class="fas fa-edit me-2"></i>Edit Customer
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" id="editForm{{ $customer->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name{{ $customer->id }}" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name{{ $customer->id }}" name="name" value="{{ $customer->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email{{ $customer->id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email{{ $customer->id }}" name="email" value="{{ $customer->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone{{ $customer->id }}" class="form-label">Phone</label>
                                            <input type="text" class="form-control" id="phone{{ $customer->id }}" name="phone" value="{{ $customer->phone }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address{{ $customer->id }}" class="form-label">Address</label>
                                            <textarea class="form-control" id="address{{ $customer->id }}" name="address" rows="3">{{ $customer->address }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="allergies{{ $customer->id }}" class="form-label">Allergies</label>
                                            <textarea class="form-control" id="allergies{{ $customer->id }}" name="allergies" rows="2">{{ $customer->allergies }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editConfirmationModal{{ $customer->id }}">
                                            <i class="fas fa-save me-1"></i>Update Customer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Confirmation Modal -->
                    <div class="modal fade" id="editConfirmationModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editConfirmationModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editConfirmationModalLabel{{ $customer->id }}">
                                        <i class="fas fa-question-circle me-2"></i>Confirm Update
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update this customer?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('editForm{{ $customer->id }}').submit();">
                                        <i class="fas fa-check me-1"></i>Yes, Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete customer <strong>{{ $customer->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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
        {{ $customers->links() }}
    </div>
</div>

<script>
// Auto focus on name input when edit modal is shown
document.addEventListener('DOMContentLoaded', function() {
    @foreach($customers as $customer)
        document.getElementById('editModal{{ $customer->id }}').addEventListener('shown.bs.modal', function () {
            document.getElementById('name{{ $customer->id }}').focus();
        });
    @endforeach
});
</script>
@endsection