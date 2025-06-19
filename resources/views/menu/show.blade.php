<!-- menu/show.blade.php -->
@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $food->image_url }}" class="img-fluid" alt="{{ $food->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $food->name }}</h2>
            <p>{{ $food->description }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($food->price, 0, ',', '.') }}</p>
            <p><strong>Nutrition:</strong> {{ $food->nutrition_fact }}</p>

            <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                @csrf
                <input type="hidden" name="food_id" value="{{ $food->id }}">

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="1" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="customization" class="form-label">Customization (Optional)</label>
                    <textarea name="customization" class="form-control" id="customization" rows="3"></textarea>
                </div>

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Add to Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to add <strong>{{ $food->name }}</strong> to your cart with the selected quantity and customization?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" form="add-to-cart-form">Confirm</button>
            </div>
        </div>
    </div>
</div>

@endsection