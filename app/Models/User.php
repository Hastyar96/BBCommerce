<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'verify_code',
        'otp_expires_at',
        'phone_verified_at',
        'cuntry_code',
        'role_id',
        'is_verify',
        'language_id',
        'is_admin',
        'office_id',
        'is_guest',
        'session',
        'subcity_id',
        'image_profile',
        'image_cover',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function subcity()
    {
        return $this->belongsTo(Subcity::class);
    }


    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
