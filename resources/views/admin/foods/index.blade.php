<!-- admin/foods/index.blade.php -->
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
    
    .modern-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .food-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
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
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">🍽️ Manajemen Makanan</h1>
                <p class="mb-0 opacity-75">Kelola menu makanan dan minuman</p>
            </div>
            <a href="{{ route('admin.foods.create') }}" class="create-btn text-decoration-none">
                <i class="fas fa-plus me-2"></i>Tambah Makanan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-utensils me-2 text-primary"></i>Daftar Makanan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Gambar</th>
                        <th class="border-0 fw-bold">Nama</th>
                        <th class="border-0 fw-bold">Kategori</th>
                        <th class="border-0 fw-bold">Deskripsi</th>
                        <th class="border-0 fw-bold">Harga</th>
                        <th class="border-0 fw-bold">Kalori</th>
                        <th class="border-0 fw-bold">Status</th>
                        <th class="border-0 fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foods as $food)
                    <tr>
                        <td class="border-0">
                            @if($food->image)
                            <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="food-image">
                            @else
                            <div class="food-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td class="border-0">
                            <div class="fw-bold">{{ $food->name }}</div>
                        </td>
                        <td class="border-0">
                            <span class="badge bg-primary rounded-pill">{{ $food->category->name }}</span>
                        </td>
                        <td class="border-0">
                            <small class="text-muted">{{ Str::limit($food->description, 50) }}</small>
                        </td>
                        <td class="border-0">
                            <span class="fw-bold text-success">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="border-0">
                            <span class="badge bg-info rounded-pill">{{ $food->calories ?? 'N/A' }} kcal</span>
                        </td>
                        <td class="border-0">
                            <span class="badge rounded-pill {{ $food->is_available ? 'bg-success' : 'bg-danger' }}">
                                {{ $food->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </td>

                        <td class="border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.foods.show', $food->id) }}" class="btn btn-info action-btn btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-warning action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $food->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger action-btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $food->id }}" title="Hapus">
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

    @foreach($foods as $food)

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $food->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $food->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editModalLabel{{ $food->id }}">
                                        <i class="fas fa-edit me-2"></i>Edit Food
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data" id="editForm{{ $food->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name{{ $food->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name{{ $food->id }}" name="name" value="{{ $food->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category_id{{ $food->id }}" class="form-label">Category</label>
                                                    <select class="form-control" id="category_id{{ $food->id }}" name="category_id" required>
                                                        @foreach(\App\Models\Category::all() as $category)
                                                            <option value="{{ $category->id }}" {{ $food->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $food->id }}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description{{ $food->id }}" name="description" rows="3" required>{{ $food->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price{{ $food->id }}" class="form-label">Price (Rp)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control" id="price{{ $food->id }}" name="price" value="{{ $food->price }}" step="1" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nutrition_fact{{ $food->id }}" class="form-label">Nutrition Facts</label>
                                                    <textarea class="form-control" id="nutrition_fact{{ $food->id }}" name="nutrition_fact" rows="3" required>{{ $food->nutrition_fact }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="calories{{ $food->id }}" class="form-label">Calories</label>
                                                    <input type="number" class="form-control" id="calories{{ $food->id }}" name="calories" value="{{ $food->calories }}" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="protein{{ $food->id }}" class="form-label">Protein (g)</label>
                                                    <input type="number" class="form-control" id="protein{{ $food->id }}" name="protein" value="{{ $food->protein }}" step="0.1" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="carbs{{ $food->id }}" class="form-label">Carbs (g)</label>
                                                    <input type="number" class="form-control" id="carbs{{ $food->id }}" name="carbs" value="{{ $food->carbs }}" step="0.1" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fat{{ $food->id }}" class="form-label">Fat (g)</label>
                                                    <input type="number" class="form-control" id="fat{{ $food->id }}" name="fat" value="{{ $food->fat }}" step="0.1" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="image{{ $food->id }}" class="form-label">Image</label>
                                                    <input type="file" class="form-control" id="image{{ $food->id }}" name="image" accept="image/*">
                                                    @if($food->image)
                                                        <div class="mt-2">
                                                            <img src="{{ $food->image_url }}" alt="Current image" class="img-thumbnail" style="max-width: 100px;">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_available{{ $food->id }}" name="is_available" {{ $food->is_available ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_available{{ $food->id }}">Available</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_vegetarian{{ $food->id }}" name="is_vegetarian" {{ $food->is_vegetarian ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_vegetarian{{ $food->id }}">Vegetarian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_vegan{{ $food->id }}" name="is_vegan" {{ $food->is_vegan ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_vegan{{ $food->id }}">Vegan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_gluten_free{{ $food->id }}" name="is_gluten_free" {{ $food->is_gluten_free ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_gluten_free{{ $food->id }}">Gluten Free</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_dairy_free{{ $food->id }}" name="is_dairy_free" {{ $food->is_dairy_free ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_dairy_free{{ $food->id }}">Dairy Free</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_low_calorie{{ $food->id }}" name="is_low_calorie" {{ $food->is_low_calorie ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_low_calorie{{ $food->id }}">Low Calorie</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editConfirmationModal{{ $food->id }}">
                                            <i class="fas fa-save me-1"></i>Update Food
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Confirmation Modal -->
                    <div class="modal fade" id="editConfirmationModal{{ $food->id }}" tabindex="-1" aria-labelledby="editConfirmationModalLabel{{ $food->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="editConfirmationModalLabel{{ $food->id }}">
                                        <i class="fas fa-question-circle me-2"></i>Confirm Update
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update this food item?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('editForm{{ $food->id }}').submit();">
                                        <i class="fas fa-check me-1"></i>Yes, Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{ $food->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $food->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $food->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the food <strong>{{ $food->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" class="d-inline">
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
        {{ $foods->links() }}
    </div>
</div>

<script>
// Auto focus on name input when edit modal is shown
document.addEventListener('DOMContentLoaded', function() {
    @foreach($foods as $food)
        document.getElementById('editModal{{ $food->id }}').addEventListener('shown.bs.modal', function () {
            document.getElementById('name{{ $food->id }}').focus();
        });
    @endforeach
});
</script>
@endsection