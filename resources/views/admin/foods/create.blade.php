<!-- admin/foods/create.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Create Food</h1>

    <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Food Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="price">Price (Rp)</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}" step="1" required placeholder="0">
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="nutrition_fact">Nutrition Facts</label>
            <input type="text" class="form-control" name="nutrition_fact" id="nutrition_fact" value="{{ old('nutrition_fact') }}">
        </div>

        <div class="form-group mb-3">
            <label for="calories">Calories</label>
            <input type="number" class="form-control" name="calories" id="calories" value="{{ old('calories') }}">
        </div>

        <div class="form-group mb-3">
            <label for="protein">Protein</label>
            <input type="number" class="form-control" name="protein" id="protein" value="{{ old('protein') }}">
        </div>

        <div class="form-group mb-3">
            <label for="carbs">Carbs</label>
            <input type="number" class="form-control" name="carbs" id="carbs" value="{{ old('carbs') }}">
        </div>

        <div class="form-group mb-3">
            <label for="fat">Fat</label>
            <input type="number" class="form-control" name="fat" id="fat" value="{{ old('fat') }}">
        </div>

        <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <div class="form-group mb-3">
            <label for="is_vegetarian">Vegetarian</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_vegetarian" id="is_vegetarian" {{ old('is_vegetarian') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_vegetarian">{{ old('is_vegetarian') ? 'True' : 'False' }}</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="is_vegan">Vegan</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_vegan" id="is_vegan" {{ old('is_vegan') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_vegan">{{ old('is_vegan') ? 'True' : 'False' }}</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="is_dairy_free">Dairy-Free</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_dairy_free" id="is_dairy_free" {{ old('is_dairy_free') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_dairy_free">{{ old('is_dairy_free') ? 'True' : 'False' }}</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="is_gluten_free">Gluten-Free</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_gluten_free" id="is_gluten_free" {{ old('is_gluten_free') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_gluten_free">{{ old('is_gluten_free') ? 'True' : 'False' }}</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="is_low_calorie">Low Calorie</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_low_calorie" id="is_low_calorie" {{ old('is_low_calorie') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_low_calorie">{{ old('is_low_calorie') ? 'True' : 'False' }}</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="is_available">Available</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="is_available" id="is_available" {{ old('is_available') ? 'checked' : 'checked' }}>
                <label class="form-check-label" for="is_available">{{ old('is_available') ? 'True' : 'False' }}</label>
            </div>
        </div>


        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
            Create Food
        </button>

        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Food Creation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to create this food with the entered details?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection