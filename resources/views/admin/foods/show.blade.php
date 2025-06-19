<!-- admin/foods/show.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Food Details</h1>

    <div class="card">
        <div class="card-header">
            <h5>{{ $food->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $food->image_url }}" class="img-fluid" alt="{{ $food->name }}">
                </div>
                <div class="col-md-8">
                    <h6 class="mb-2">Category:</h6>
                    <p>{{ $food->category->name }}</p>

                    <h6 class="mb-2">Description:</h6>
                    <p>{{ $food->description }}</p>

                    <h6 class="mb-2">Price:</h6>
                    <p>Rp {{ number_format($food->price, 0, ',', '.') }}</p>

                    <h6 class="mb-2">Nutrition Facts:</h6>
                    <p>{{ $food->nutrition_fact }}</p>

                    @if($food->calories)
                    <h6 class="mb-2">Calories:</h6>
                    <p>{{ $food->calories }} kcal</p>
                    @endif

                    @if($food->protein)
                    <h6 class="mb-2">Protein:</h6>
                    <p>{{ $food->protein }} g</p>
                    @endif

                    @if($food->carbs)
                    <h6 class="mb-2">Carbs:</h6>
                    <p>{{ $food->carbs }} g</p>
                    @endif

                    @if($food->fat)
                    <h6 class="mb-2">Fat:</h6>
                    <p>{{ $food->fat }} g</p>
                    @endif

                    <h6 class="mb-2">Dietary Restrictions:</h6>
                    <ul>
                        @if($food->is_vegetarian) <li>Vegetarian</li> @endif
                        @if($food->is_vegan) <li>Vegan</li> @endif
                        @if($food->is_dairy_free) <li>Dairy Free</li> @endif
                        @if($food->is_gluten_free) <li>Gluten Free</li> @endif
                        @if($food->is_low_calorie) <li>Low Calorie</li> @endif
                    </ul>

                    <a href="{{ route('admin.foods.index') }}" class="btn btn-outline-secondary">Back to Food List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection