<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Pengajuan() {
        return $this->hasMany(Pengajuan::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
