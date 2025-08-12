<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
 public function toArray($request)
    {
        $langId = auth()->user()->language_id ?? 1;
        $productLang = $this->langs->where('language_id', $langId)->first();
        $categoryLang = $this->category?->langs->where('language_id', $langId)->first();
        $brandLang = $this->brand?->langs->where('language_id', $langId)->first();

        return [
            'id' => $this->id,
            'status' => $this->status,
            'for_gift' => $this->for_gift,
            'for_sell' => $this->for_sell,
            'for_buy' => $this->for_buy,
            'buy_price' => $this->buy_price,
            'note' => $this->note,
            'serving_g' => $this->serving_g,
            'name' => $productLang?->name,
            'description' => $productLang?->description,
            'image' => $productLang?->image,
            'suited_for' => $productLang?->suited_for,
            'recommended_use' => $productLang?->recommended_use,
            'category' => [
                'id' => $this->category?->id,
                'name' => $categoryLang?->name,
                'description' => $categoryLang?->description,
                'image' => $this->category?->image,
            ],
            'brand' => [
                'id' => $this->brand?->id,
                'name' => $brandLang?->name,
                'description' => $brandLang?->description,
                'logo' => $this->brand?->logo,
            ],
            'images' => $this->images->map(fn($img) => [
                'id' => $img->id,
                'image' => $img->image,
            ]),
            'prices' => $this->price->map(fn($p) => [
                'id' => $p->id,
                'price' => $p->price,
                'currency_id' => $p->currency_id,
                'currency_code' => $p->currency?->code,
                'currency_symbol' => $p->currency?->symbol,
                'is_active' => $p->is_active,
            ]),
            'tags' => $this->tags->map(fn($tag) => [
                'tag_id' => $tag->id,
                'tag_name' => $tag->langs->where('language_id', $langId)->first()?->name,
                'tag_description' => $tag->langs->where('language_id', $langId)->first()?->description,
                'tag_image' => $tag->image,
                'lang_id' => $tag->langs->where('language_id', $langId)->first()?->language_id,
                'lang_code' => $tag->langs->where('language_id', $langId)->first()?->language?->code,
                'lang_name' => $tag->langs->where('language_id', $langId)->first()?->language?->name,
            ]),
            'goals' => $this->goals->map(fn($goal) => [
                'goal_id' => $goal->id,
                'goal_name' => $goal->langs->where('language_id', $langId)->first()?->name,
                'goal_description' => $goal->langs->where('language_id', $langId)->first()?->description,
                'goal_image' => $goal->image,
                'lang_id' => $goal->langs->where('language_id', $langId)->first()?->language_id,
                'lang_code' => $goal->langs->where('language_id', $langId)->first()?->language?->code,
                'lang_name' => $goal->langs->where('language_id', $langId)->first()?->language?->name,
            ]),
            'tastes' => $this->tastes->map(fn($taste) => [
                'taste_id' => $taste->id,
                'taste_name' => $taste->langs->where('language_id', $langId)->first()?->name,
                'lang_id' => $taste->langs->where('language_id', $langId)->first()?->language_id,
                'lang_code' => $taste->langs->where('language_id', $langId)->first()?->language?->code,
                'lang_name' => $taste->langs->where('language_id', $langId)->first()?->language?->name,
            ]),
        ];
    }
}
