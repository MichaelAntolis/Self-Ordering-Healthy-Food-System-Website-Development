<!-- admin/reports/sales.blade.php -->
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

    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .filter-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .table-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .date-input {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .date-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">📊 Laporan Penjualan</h1>
                <p class="mb-0 opacity-75">Analisis performa penjualan dan tren bisnis</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <h5 class="mb-3 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Periode</h5>
        <form method="GET" action="{{ route('admin.reports.sales') }}">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control date-input" value="{{ old('start_date', $startDate->toDateString()) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control date-input" value="{{ old('end_date', $endDate->toDateString()) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">&nbsp;</label>
                    <button type="submit" class="btn filter-btn w-100">
                        <i class="fas fa-search me-2"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h6 class="text-muted mb-1">Total Penjualan</h6>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h6 class="text-muted mb-1">Total Pesanan</h6>
                <h3 class="fw-bold text-primary mb-0">{{ $totalOrders }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h6 class="text-muted mb-1">Rata-rata Nilai Pesanan</h6>
                <h3 class="fw-bold text-warning mb-0">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2 text-primary"></i>Penjualan Harian</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Tanggal</th>
                        <th class="border-0 fw-bold">Jumlah Pesanan</th>
                        <th class="border-0 fw-bold">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySales as $sale)
                    <tr>
                        <td class="border-0">
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($sale->date)->format('l') }}</small>
                        </td>
                        <td class="border-0">
                            <span class="badge bg-primary rounded-pill">{{ $sale->order_count }} pesanan</span>
                        </td>
                        <td class="border-0">
                            <div class="fw-bold text-success">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection