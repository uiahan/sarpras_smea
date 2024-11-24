<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function Jurusan()
    {
        return $this->hasMany(Jurusan::class);
    }

    public function SumberDana()
    {
        return $this->hasMany(SumberDana::class);
    }

    public function Pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function Detail()
    {
        return $this->hasMany(Detail::class);
    }

    // User.php
    public function uploads()
    {
        return $this->hasMany(Upload::class, 'user_id');
    }

    public function Format()
    {
        return $this->hasMany(Format::class, 'user_id');
    }
    public function FormatPengajuan()
    {
        return $this->hasMany(FormatPengajuan::class, 'user_id');
    }

    public function FormatPengambilan()
    {
        return $this->hasMany(FormatPengambilan::class, 'user_id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
