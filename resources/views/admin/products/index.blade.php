@extends('layouts.admin')

@section('title', 'Products')
@section('heading', 'Products')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">{{ $products->total() }} products total</p>
        @if(auth('admin')->user()->hasPermission('create_products'))
            <a href="{{ route('admin.products.create') }}"
                class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + New Product
            </a>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Brand</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $product->name_en }}
                            <span class="block text-xs text-gray-400">{{ $product->name_ar }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->category->name_en ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->brand->name_en ?? '—' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                @if(auth('admin')->user()->hasPermission('update_products'))
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-xs text-teal-600 hover:text-teal-800 font-medium">Edit</a>
                                @endif
                                @if(auth('admin')->user()->hasPermission('delete_products'))
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                        onsubmit="return confirm('Delete this product?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-red-500 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                            No products found. <a href="{{ route('admin.products.create') }}"
                                class="text-teal-600 underline">Create one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($products->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection