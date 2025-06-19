<!-- admin/reports/popular-foods.blade.php -->
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
    
    .food-rank {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 1.1rem;
    }
    
    .rank-1 { background: linear-gradient(135deg, #ffd700, #ffed4e); }
    .rank-2 { background: linear-gradient(135deg, #c0c0c0, #e5e5e5); }
    .rank-3 { background: linear-gradient(135deg, #cd7f32, #daa520); }
    .rank-other { background: linear-gradient(135deg, #6c757d, #adb5bd); }
    
    .food-link {
        color: #495057;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .food-link:hover {
        color: #667eea;
        text-decoration: none;
    }
    
    .category-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .orders-count {
        background: linear-gradient(135deg, #28a745, #20c997);
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
                <h1 class="mb-2">🏆 Makanan Populer</h1>
                <p class="mb-0 opacity-75">Ranking makanan berdasarkan jumlah pesanan</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-trophy me-2 text-warning"></i>Top Makanan Terlaris</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Ranking</th>
                        <th class="border-0 fw-bold">Nama Makanan</th>
                        <th class="border-0 fw-bold">Kategori</th>
                        <th class="border-0 fw-bold">Harga</th>
                        <th class="border-0 fw-bold">Total Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($popularFoods as $index => $food)
                    <tr>
                        <td class="border-0">
                            <div class="food-rank 
                                @if($index == 0) rank-1
                                @elseif($index == 1) rank-2
                                @elseif($index == 2) rank-3
                                @else rank-other
                                @endif">
                                {{ $index + 1 }}
                            </div>
                        </td>
                        <td class="border-0">
                            <a href="{{ route('admin.foods.show', $food->id) }}" class="food-link">
                                <div class="fw-bold">{{ $food->name }}</div>
                            </a>
                        </td>
                        <td class="border-0">
                            <span class="category-badge">{{ $food->category_name }}</span>
                        </td>
                        <td class="border-0">
                            <div class="fw-bold text-success">Rp {{ number_format($food->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="border-0">
                            <span class="orders-count">{{ $food->total_quantity }} pesanan</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection