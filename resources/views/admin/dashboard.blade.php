<!-- admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<style>
    .stats-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    }
    
    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .stats-card.orders {
        --gradient-start: #667eea;
        --gradient-end: #764ba2;
    }
    
    .stats-card.revenue {
        --gradient-start: #f093fb;
        --gradient-end: #f5576c;
    }
    
    .stats-card.customers {
        --gradient-start: #4facfe;
        --gradient-end: #00f2fe;
    }
    
    .stats-card.menu {
        --gradient-start: #43e97b;
        --gradient-end: #38f9d7;
    }
    
    .stats-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.3;
        font-size: 3.5rem;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 10px 0;
    }
    
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .modern-table {
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
    <div class="dashboard-header">
        <h1 class="mb-2">🍽️ Admin Dashboard</h1>
        <p class="mb-0 opacity-75">Selamat datang di panel admin Healthy Food Self-Ordering</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card orders text-white h-100">
                <div class="card-body position-relative">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h6 class="text-white-50 mb-0 text-uppercase fw-bold">Total Orders</h6>
                    <div class="stats-number">{{ $totalOrders }}</div>
                    <p class="mb-0"><i class="fas fa-calendar-day me-1"></i>{{ $todayOrders }} hari ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card revenue text-white h-100">
                <div class="card-body position-relative">
                    <div class="stats-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h6 class="text-white-50 mb-0 text-uppercase fw-bold">Total Revenue</h6>
                    <div class="stats-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <p class="mb-0"><i class="fas fa-chart-line me-1"></i>Semua waktu</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card customers text-white h-100">
                <div class="card-body position-relative">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6 class="text-white-50 mb-0 text-uppercase fw-bold">Customers</h6>
                    <div class="stats-number">{{ $totalCustomers }}</div>
                    <p class="mb-0"><i class="fas fa-user-check me-1"></i>Pelanggan terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card menu text-white h-100">
                <div class="card-body position-relative">
                    <div class="stats-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h6 class="text-white-50 mb-0 text-uppercase fw-bold">Menu Items</h6>
                    <div class="stats-number">{{ $totalFoods }}</div>
                    <p class="mb-0"><i class="fas fa-list me-1"></i>Dalam {{ $totalCategories }} kategori</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card modern-table border-0">
                <div class="table-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Pesanan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Order #</th>
                                    <th class="border-0 fw-bold">Customer</th>
                                    <th class="border-0 fw-bold">Type</th>
                                    <th class="border-0 fw-bold">Amount</th>
                                    <th class="border-0 fw-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestOrders as $order)
                                <tr>
                                    <td class="border-0">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none fw-bold text-primary">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="border-0">{{ $order->customer->name }}</td>
                                    <td class="border-0">
                                        <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</span>
                                    </td>
                                    <td class="border-0 fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="border-0">
                                        <span class="badge rounded-pill bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'primary' : 'danger')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center p-3 border-top">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-eye me-2"></i>Lihat Semua Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card modern-table border-0">
                <div class="table-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-fire me-2 text-danger"></i>Makanan Populer</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Food Item</th>
                                    <th class="border-0 fw-bold">Category</th>
                                    <th class="border-0 fw-bold">Price</th>
                                    <th class="border-0 fw-bold">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularFoods as $food)
                                <tr>
                                    <td class="border-0">
                                        <a href="{{ route('admin.foods.show', $food->id) }}" class="text-decoration-none fw-bold text-primary">
                                            {{ $food->name }}
                                        </a>
                                    </td>
                                    <td class="border-0">
                                        <span class="badge bg-light text-dark">{{ $food->category->name }}</span>
                                    </td>
                                    <td class="border-0 fw-bold">Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                                    <td class="border-0">
                                        <span class="badge bg-success rounded-pill">{{ $food->total_ordered }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center p-3 border-top">
                        <a href="{{ route('admin.reports.popular-foods') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Laporan Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card modern-table border-0">
                <div class="table-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-info"></i>Laporan Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="report-card">
                                <a href="{{ route('admin.reports.category-foods') }}" class="btn btn-outline-primary w-100 py-4 rounded-3 border-2 position-relative overflow-hidden">
                                    <div class="report-icon">
                                        <i class="fas fa-list-ul fa-2x mb-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Kategori Terpopuler</h6>
                                    <small class="text-muted">Kategori dengan makanan terbanyak</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="report-card">
                                <a href="{{ route('admin.reports.top-customers') }}" class="btn btn-outline-success w-100 py-4 rounded-3 border-2 position-relative overflow-hidden">
                                    <div class="report-icon">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Pelanggan Teratas</h6>
                                    <small class="text-muted">Pelanggan dengan pesanan terbanyak</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="report-card">
                                <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-warning w-100 py-4 rounded-3 border-2 position-relative overflow-hidden">
                                    <div class="report-icon">
                                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Laporan Penjualan</h6>
                                    <small class="text-muted">Analisis penjualan dan revenue</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection