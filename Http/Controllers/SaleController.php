<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Requests\SaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Services\SaleRecorder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function create(): View
    {
        return view('sales.create', [
            'products' => Product::orderBy('name')->get(['id', 'name', 'price', 'stock_quantity']),
            'customers' => Customer::orderBy('full_name')->get(['id', 'full_name']),
        ]);
    }

    public function store(SaleRequest $request, SaleRecorder $recorder): RedirectResponse
    {
        try {
            $sale = $recorder->record(
                (int) $request->validated('product_id'),
                $request->validated('customer_id') ? (int) $request->validated('customer_id') : null,
                (int) $request->validated('quantity'),
                $request->user()->id,
            );
        } catch (InsufficientStockException $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect()->route('sales.index')
            ->with('success', "Sale recorded: {$sale->quantity} × {$sale->product->name} for ".\App\Support\Money::format($sale->total_price).'.');
    }
}
