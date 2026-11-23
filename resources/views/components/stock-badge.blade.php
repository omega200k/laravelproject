@props(['product'])
@if ($product->isOutOfStock())
    <span class="badge-red">Out of stock</span>
@elseif ($product->isLowStock())
    <span class="badge-amber">Low stock · {{ $product->stock_quantity }}</span>
@else
    <span class="badge-green">In stock · {{ $product->stock_quantity }}</span>
@endif
