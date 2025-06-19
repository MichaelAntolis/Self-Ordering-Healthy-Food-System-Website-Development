<!-- admin/categories/index.blade.php -->
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
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">🏷️ Manajemen Kategori</h1>
                <p class="mb-0 opacity-75">Kelola kategori makanan dan minuman</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="create-btn text-decoration-none">
                <i class="fas fa-plus me-2"></i>Tambah Kategori Baru
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
            <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i>Daftar Kategori</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Icon</th>
                        <th class="border-0 fw-bold">Nama Kategori</th>
                        <th class="border-0 fw-bold">Deskripsi</th>
                        <th class="border-0 fw-bold">Jumlah Makanan</th>
                        <th class="border-0 fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td class="border-0">
                            <div class="category-icon bg-primary">
                                <i class="fas fa-utensils"></i>
                            </div>
                        </td>
                        <td class="border-0">
                            <div class="fw-bold">{{ $category->name }}</div>
                        </td>
                        <td class="border-0">
                            <span class="text-muted">{{ $category->description }}</span>
                        </td>
                        <td class="border-0">
                            <span class="badge bg-info rounded-pill">{{ $category->foods_count ?? 0 }} item</span>
                        </td>
                        <td class="border-0">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-warning action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}" title="Hapus">
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

    @foreach($categories as $category)

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editModalLabel{{ $category->id }}">
                                        <i class="fas fa-edit me-2"></i>Edit Category
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="editForm{{ $category->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name{{ $category->id }}" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description{{ $category->id }}" class="form-label">Description</label>
                                            <textarea class="form-control" id="description{{ $category->id }}" name="description" rows="3">{{ $category->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editConfirmationModal{{ $category->id }}">
                                            <i class="fas fa-save me-1"></i>Update Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Confirmation Modal -->
                    <div class="modal fade" id="editConfirmationModal{{ $category->id }}" tabindex="-1" aria-labelledby="editConfirmationModalLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editConfirmationModalLabel{{ $category->id }}">
                                        <i class="fas fa-question-circle me-2"></i>Confirm Update
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update this category?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('editForm{{ $category->id }}').submit();">
                                        <i class="fas fa-check me-1"></i>Yes, Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the category <strong>{{ $category->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
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
        {{ $categories->links() }}
    </div>
</div>

<script>
// Auto focus on name input when edit modal is shown
document.addEventListener('DOMContentLoaded', function() {
    @foreach($categories as $category)
        document.getElementById('editModal{{ $category->id }}').addEventListener('shown.bs.modal', function () {
            document.getElementById('name{{ $category->id }}').focus();
        });
    @endforeach
});
</script>
@endsection