<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

    public function SumberDana() {
        return $this->belongsTo(SumberDana::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Detail() {
        return $this->hasMany(Detail::class);
    }
}
