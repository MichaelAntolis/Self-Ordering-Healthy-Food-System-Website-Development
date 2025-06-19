<!-- admin/customers/show.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Customer Details</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5>{{ $customer->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
                    <p><strong>Allergies:</strong> {{ $customer->allergies ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h6>Orders Count: {{ $customer->orders_count }}</h6>
                </div>
            </div>
        </div>
    </div>

    <h2>Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Order Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customer->orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>Rp {{ number_format( $order->total_amount*10000, 0, ',', '.')}}</td>
                <td>{{ ucfirst($order->order_type) }}</td>
                <td>
                    <a href="{{ route('admin.customers.show', $order->id) }}" class="btn btn-info btn-sm">View Order</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary mt-4">Back to Customers List</a>
</div>
@endsection