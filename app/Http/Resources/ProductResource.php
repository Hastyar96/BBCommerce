<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $this->langs->first(); // or filter by language_id

        return [
            'id' => $this->id,
            'status' => $this->status,
            'for_gift' => $this->for_gift,
            'for_sell' => $this->for_sell,
            'for_buy' => $this->for_buy,
            'buy_price' => $this->buy_price,
            'note' => $this->note,
            'serving_g' => $this->serving_g,

            // Langs (translation)
            'langs' => $this->langs->map(function ($lang) {
                return [
                    'id' => $lang->id,
                    'language_id' => $lang->language_id,
                    'language_name' => $lang->language?->name,
                    'name' => $lang->name,
                    'description' => $lang->description,
                    'suited_for' => $lang->suited_for,
                    'recommended_use' => $lang->recommended_use,
                ];
            }),

            // Brand info
            'brand' => [
                'id' => $this->brand?->id,
                'logo' => $this->brand?->logo,
                'langs' => $this->brand?->langs->map(function ($lang) {
                    return [
                        'id' => $lang->id,
                        'language_id' => $lang->language_id,
                        'name' => $lang->name,
                        'description' => $lang->description,
                    ];
                }),
            ],


            // Category info
            'category' => [
                'id' => $this->category?->id,
                'image' => $this->category?->image,
                'langs' => $this->category?->langs->map(function ($lang) {
                    return [
                        'id' => $lang->id,
                        'language_id' => $lang->language_id,
                        'language_name' => $lang->language?->name,
                        'name' => $lang->name,
                        'description' => $lang->description,
                    ];
                }),
            ],


            // Image
            'images' => $this->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'image' => $img->image,
                ];
            }),
            // Price
            'prices' => $this->price->map(function ($p) {
                return [
                    'id' => $p->id,
                    'price' => $p->price,
                    'currency_id' => $p->currency_id,
                    'currency_code' => $p->currency?->code,
                    'currency_symbol' => $p->currency?->symbol,
                    'is_active' => $p->is_active,
                ];
            }),

            // Tags
            'tags' => $this->tags->map(function ($tag) {
                $lang = $tag->langs->first();
                return [
                    'tag_id' => $tag->id,
                    'tag_name' => $lang?->name,
                    'tag_description' => $lang?->description,
                    'tag_image' => $tag->image,
                    'lang_id' => $lang?->language_id,
                    'lang_code' => $lang?->language?->code,
                    'lang_name' => $lang?->language?->name,
                ];
            }),

            // Goals
            'goals' => $this->goals->map(function ($goal) {
                $lang = $goal->langs->first();
                return [
                    'goal_id' => $goal->id,
                    'goal_name' => $lang?->name,
                    'goal_description' => $lang?->description,
                    'goal_image' => $goal->image,
                    'lang_id' => $lang?->language_id,
                    'lang_code' => $lang?->language?->code,
                    'lang_name' => $lang?->language?->name,
                ];
            }),

            // Tastes
            'tastes' => $this->tastes->map(function ($taste) {
                $lang = $taste->langs->first();
                return [
                    'taste_id' => $taste->id,
                    'taste_name' => $lang?->name,
                    'lang_id' => $lang?->language_id,
                    'lang_code' => $lang?->language?->code,
                    'lang_name' => $lang?->language?->name,
                ];
            }),
        ];
    }
}
