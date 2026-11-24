<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'staff' => ['nullable', 'integer'],
        ]);

        $term = $request->string('q')->trim()->value();

        $sales = Sale::query()
            ->with(['product:id,name', 'customer:id,full_name', 'staff:id,full_name'])
            ->when($term, function ($q, $term) {
                $q->where(function ($w) use ($term) {
                    $w->whereHas('product', fn ($p) => $p->where('name', 'like', "%{$term}%"))
                        ->orWhereHas('customer', fn ($c) => $c->where('full_name', 'like', "%{$term}%"))
                        ->orWhereHas('staff', fn ($s) => $s->where('full_name', 'like', "%{$term}%"));
                    if (preg_match('/walk/i', $term)) {
                        $w->orWhereNull('customer_id');
                    }
                });
            })
            ->when($request->filled('staff'), fn ($q) => $q->where('sold_by', $request->integer('staff')))
            ->when($request->filled('from'), fn ($q) => $q->where('created_at', '>=', $request->date('from')->startOfDay()))
            ->when($request->filled('to'), fn ($q) => $q->where('created_at', '<=', $request->date('to')->endOfDay()))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.index', [
            'sales' => $sales,
            'staffList' => User::orderBy('full_name')->get(['id', 'full_name']),
        ]);
    }
}
