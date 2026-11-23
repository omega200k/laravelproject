<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'price', 'stock_quantity', 'image'])]
class Product extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public const LOW_STOCK_THRESHOLD = 5;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => Media::url($this->image, Media::PRODUCT_FALLBACK));
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    public function isLowStock(): bool
    {
        return ! $this->isOutOfStock() && $this->stock_quantity <= self::LOW_STOCK_THRESHOLD;
    }
}
