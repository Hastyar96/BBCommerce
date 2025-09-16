<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $this->langs->first();
        $userId = auth()->id();

        // Calculate discount percentage
        $price = $this->activePrice->price ?? $this->price->price ?? 0;
        $discountPrice = $this->activePrice->discount_price ?? $this->price->discount_price ?? 0;
        $discountPercentage = ($price > 0 && $discountPrice > 0 && $discountPrice > $price)
            ? round((($discountPrice - $price) / $discountPrice) * 100) . '%'
            : '0%';

        return [
            'id' => $this->id,
            'name' => $lang?->name ?? '',
            'price' => $price,
            'discount_price' => $discountPrice,
            'discount_percentage' => $discountPercentage, // New field
            'image' => $this->images->pluck('image')->toArray(),
            'currency_symbol' => $this->activePrice?->currency->symbol ?? $this->price?->currency->symbol ?? '',
            'category' => $this->category?->langs->first()?->name ?? '',
            'brand' => $this->brand?->langs->first()?->name ?? '',

            // Extra user-based info
            'is_favorited' => $this->isFavoritedBy($userId),
            'is_liked' => $this->isLikedBy($userId),

            // Counts
            'likes_count' => $this->likes_count ?? $this->likes()->count(),
            'reviews_count' => $this->reviews_count ?? $this->reviews()->count(),

            // Add average review rating
            'average_rating' => $this->reviews->count() > 0 ? round($this->reviews->avg('rating'), 1) : 0,

            // Tags, Goals, Tastes
            'tags' => $this->tags->map(fn($tag) => $tag->langs->first()?->name ?? '')->toArray(),
            'goals' => $this->goals->map(fn($goal) => $goal->langs->first()?->name ?? '')->toArray(),
            'tastes' => $this->tastes->map(fn($taste) => $taste->langs->first()?->name ?? '')->toArray(),
        ];
    }
}
