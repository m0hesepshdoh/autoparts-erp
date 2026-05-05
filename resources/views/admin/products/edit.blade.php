@extends('layouts.admin')

@section('title', 'Edit Product')
@section('heading', 'Edit: ' . $product->name_en)

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5">
        @csrf
        @method('PUT')

        {{-- Same fields as create, pre-filled with $product values --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name (AR)</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required dir="rtl"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" step="0.01" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        {{-- Current Images Preview --}}
        @if($product->images && count($product->images) > 0)
        <div>
            <p class="text-sm font-medium text-gray-700 mb-2">Current Images</p>
            <div class="flex gap-2 flex-wrap">
                @foreach($product->images as $img)
                    @if($img !== 'default.png')
                        <img src="{{ asset('storage/' . $img) }}" alt="Product image"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Replace Images</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg transition">
                Cancel
            </a>
            <button type="submit"
                class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection