<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploadpengambilan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Uploadpengambilan.php
    public function Pengajuan()
    {
        return $this->belongsTo(User::class, 'pengajuan_id');
    }
}
