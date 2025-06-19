<!-- admin/reports/category-foods.blade.php -->
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
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
    }
    
    .category-1 { background: linear-gradient(135deg, #ff6b6b, #ee5a52); }
    .category-2 { background: linear-gradient(135deg, #4ecdc4, #44a08d); }
    .category-3 { background: linear-gradient(135deg, #45b7d1, #96c93d); }
    .category-4 { background: linear-gradient(135deg, #f9ca24, #f0932b); }
    .category-5 { background: linear-gradient(135deg, #6c5ce7, #a29bfe); }
    .category-6 { background: linear-gradient(135deg, #fd79a8, #fdcb6e); }
    .category-7 { background: linear-gradient(135deg, #00b894, #00cec9); }
    .category-8 { background: linear-gradient(135deg, #e17055, #d63031); }
    
    .foods-count {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">🏷️ Kategori Makanan</h1>
                <p class="mb-0 opacity-75">Statistik kategori berdasarkan jumlah makanan</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i>Kategori dengan Makanan Terbanyak</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Kategori</th>
                        <th class="border-0 fw-bold">Deskripsi</th>
                        <th class="border-0 fw-bold">Jumlah Makanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                    <tr>
                        <td class="border-0">
                            <div class="d-flex align-items-center">
                                <div class="category-icon category-{{ ($index % 8) + 1 }}">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $category->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="border-0">
                            <span class="text-muted">{{ $category->description }}</span>
                        </td>
                        <td class="border-0">
                            <span class="foods-count">{{ $category->foods_count }} makanan</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection