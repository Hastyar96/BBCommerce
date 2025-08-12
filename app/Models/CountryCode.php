<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
 protected $fillable = [
        'country_name',
        'iso_code',
        'dialing_code',
        'flag_path',
    ];

    // Optional: accessor for emoji-style flag from ISO code 🇮🇶
    public function getFlagEmojiAttribute()
    {
        $offset = 127397; // Unicode offset for regional indicator symbols
        return strtoupper($this->iso_code)
            ? implode('', array_map(
                fn($char) => mb_chr(ord($char) + $offset, 'UTF-8'),
                str_split(strtoupper($this->iso_code))
            ))
            : null;
    }
}
