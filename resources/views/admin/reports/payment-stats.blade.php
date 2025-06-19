<!-- admin/reports/payment-stats.blade.php -->
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
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .table-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    .payment-icon {
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
    
    .qris-icon { background: linear-gradient(135deg, #00d4aa, #00b894); }
    .credit-card-icon { background: linear-gradient(135deg, #0984e3, #74b9ff); }
    .debit-card-icon { background: linear-gradient(135deg, #6c5ce7, #a29bfe); }
    .e-wallet-icon { background: linear-gradient(135deg, #fd79a8, #fdcb6e); }
    
    .transaction-count {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .percentage-badge {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-radius: 15px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">💳 Statistik Pembayaran</h1>
                <p class="mb-0 opacity-75">Analisis metode pembayaran dan transaksi</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-receipt"></i>
                </div>
                <h6 class="text-muted mb-1">Total Transaksi</h6>
                <h3 class="fw-bold text-primary mb-0">{{ $totalPayments }} transaksi</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h6 class="text-muted mb-1">Total Nilai Transaksi</h6>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Statistik Metode Pembayaran</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 fw-bold">Metode Pembayaran</th>
                        <th class="border-0 fw-bold">Jumlah Transaksi</th>
                        <th class="border-0 fw-bold">Total Nilai</th>
                        <th class="border-0 fw-bold">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentStats as $stat)
                    <tr>
                        <td class="border-0">
                            <div class="d-flex align-items-center">
                                <div class="payment-icon 
                                    @if($stat->method == 'qris') qris-icon
                                    @elseif($stat->method == 'credit_card') credit-card-icon
                                    @elseif($stat->method == 'debit_card') debit-card-icon
                                    @else e-wallet-icon
                                    @endif">
                                    @if($stat->method == 'qris')
                                        <i class="fas fa-qrcode"></i>
                                    @elseif($stat->method == 'credit_card')
                                        <i class="fas fa-credit-card"></i>
                                    @elseif($stat->method == 'debit_card')
                                        <i class="fas fa-credit-card"></i>
                                    @else
                                        <i class="fas fa-mobile-alt"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold">
                                        @if($stat->method == 'qris') QRIS
                                        @elseif($stat->method == 'credit_card') Kartu Kredit
                                        @elseif($stat->method == 'debit_card') Kartu Debit
                                        @else E-Wallet
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="border-0">
                            <span class="transaction-count">{{ $stat->count }} transaksi</span>
                        </td>
                        <td class="border-0">
                            <div class="fw-bold text-success">Rp {{ number_format($stat->total_amount, 0, ',', '.') }}</div>
                        </td>
                        <td class="border-0">
                            <span class="percentage-badge">{{ number_format($stat->percentage) }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection