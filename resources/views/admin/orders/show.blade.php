<!-- admin/orders/show.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Order Details - {{ $order->order_number }}</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Order Number: {{ $order->order_number }}</h5>
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="card-body">
            <h6>Customer</h6>
            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
            <p><strong>Address:</strong> {{ $order->customer->address }}</p>

            <h6>Special Requests</h6>
            <p>{{ $order->special_requests ?? 'No special requests' }}</p>

            <h6>Order Items</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Customization</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->foods as $food)
                    <tr>
                        <td>{{ $food->name }}</td>
                        <td>{{ $food->pivot->quantity }}</td>
                        <td>Rp {{ number_format($food->pivot->price, 0, ',', '.') }}</td>
                        <td>{{ $food->pivot->customization ?? 'No customization' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h6>Payment</h6>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</p>
            <p><strong>Amount Paid:</strong> Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
            <p><strong>Transaction ID:</strong> {{ $order->payment->transaction_id }}</p>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">Back to Orders</a>
        </div>
    </div>
</div>
@endsection