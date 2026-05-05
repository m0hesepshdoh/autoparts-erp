<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['category', 'brand', 'car'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('category_type', 'sub_category')->get();
        $brands = Brand::all();
        $cars = Car::with('factoryCar')->get();

        return view('admin.products.create', compact('categories', 'brands', 'cars'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
        }

        $data['images'] = empty($images) ? ['default.png'] : $images;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('category_type', 'sub_category')->get();
        $brands = Brand::all();
        $cars = Car::with('factoryCar')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'cars'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $images = $product->images;

        if ($request->hasFile('images')) {
            // Remove old non-default images
            foreach ($images as $img) {
                if ($img !== 'default.png') {
                    Storage::disk('public')->delete($img);
                }
            }

            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
        }

        $data['images'] = $images;
        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $img) {
            if ($img !== 'default.png') {
                Storage::disk('public')->delete($img);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }
}
