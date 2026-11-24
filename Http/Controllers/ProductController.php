<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ImageProcessor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ImageProcessor $images)
    {
    }

    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->string('q')->trim()->value(), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'price', 'stock_quantity']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->storeProductImage($request->file('image'));
        }

        $product = Product::create($data);

        return redirect()->route('products.show', $product)->with('success', 'Product created.');
    }

    public function show(Product $product): View
    {
        $product->loadCount('sales');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'price', 'stock_quantity']);
        $old = $product->image;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $data['image'] = $this->images->storeProductImage($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }

        try {
            $product->update($data);
        } catch (\Throwable $e) {
            $this->images->delete($newImage, 'product-images');
            throw $e;
        }

        if (array_key_exists('image', $data) && $old !== $data['image']) {
            $this->images->delete($old, 'product-images');
        }

        return redirect()->route('products.show', $product)->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->sales()->exists()) {
            return back()->with('error', "“{$product->name}” can't be deleted because it is part of recorded sales. Set its stock to 0 instead.");
        }

        try {
            $product->delete();
        } catch (QueryException $e) {
            return back()->with('error', "“{$product->name}” can't be deleted because it is referenced by other records.");
        }

        $this->images->delete($product->image, 'product-images');

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
