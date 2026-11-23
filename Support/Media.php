<?php

namespace App\Support;

class Media
{
    public const AVATAR_FALLBACK = 'avatar/default.png';

    public const PRODUCT_FALLBACK = 'product-images/placeholder.png';

    /**
     * Public URL for a stored relative path, or the fallback when the
     * path is empty or the file is missing from the public folder.
     */
    public static function url(?string $path, string $fallback): string
    {
        $path = $path ? ltrim($path, '/') : null;

        if ($path && ! str_contains($path, '..') && is_file(public_path($path))) {
            return asset($path);
        }

        return asset($fallback);
    }
}
