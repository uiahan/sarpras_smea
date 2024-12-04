<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKodeBarang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function KodeBarang() {
        return $this->belongsTo(KodeBarang::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
