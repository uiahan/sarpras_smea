<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatPengajuan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Upload.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
