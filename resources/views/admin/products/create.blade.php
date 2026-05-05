@extends('layouts.admin')

@section('title', 'Create Product')
@section('heading', 'Create Product')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5">
        @csrf

        {{-- Names --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en') }}" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('name_en') border-red-400 @enderror">
                @error('name_en') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name (AR)</label>
                <input type="text" name="name_ar" value="{{ old('name_ar') }}" required dir="rtl"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('name_ar') border-red-400 @enderror">
                @error('name_ar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Category / Brand / Car --}}
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">Select…</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name_en }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                <select name="brand_id" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">Select…</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Compatible Car</label>
                <select name="car_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">Any / Universal</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->factoryCar->name_en }} — {{ $car->name_en }} ({{ $car->start_year }}–{{ $car->end_year }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Pricing & Stock --}}
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}"
                       step="0.01" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                @error('purchase_price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price</label>
                <input type="number" name="price" value="{{ old('price') }}"
                       step="0.01" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        {{-- Country --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Country of Origin</label>
            <input type="text" name="country" value="{{ old('country') }}" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
        </div>

        {{-- Descriptions --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (EN)</label>
            <textarea name="description_en" rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">{{ old('description_en') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (AR)</label>
            <textarea name="description_ar" rows="3" dir="rtl"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">{{ old('description_ar') }}</textarea>
        </div>

        {{-- Images --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Images</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg transition">
                Cancel
            </a>
            <button type="submit"
                class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition">
                Create Product
            </button>
        </div>
    </form>
</div>
@endsection