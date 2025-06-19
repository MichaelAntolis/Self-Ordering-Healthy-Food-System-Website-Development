<!-- menu/index.blade.php -->
@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h2 class="text-center mb-5">Healthy Food Menu</h2>

    <form method="GET" action="{{ route('menu') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="all" {{ request()->category == 'all' ? 'selected' : '' }}>All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($foods as $food)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg">
                @if($food->image)
                <img src="{{ $food->image_url }}" class="card-img-top menu-item-image" alt="{{ $food->name }}">
                @else
                <div class="bg-light text-center py-5">
                    <i class="fas fa-image fa-3x text-secondary"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">{{ Str::limit($food->description, 100) }}</p>
                    <p class="fw-bold text-success">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                    <a href="{{ route('menu.show', $food->id) }}" class="btn btn-outline-success">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Section -->
    <div class="container mt-5">
        {{ $foods->links() }}
    </div>
</section>
@endsection