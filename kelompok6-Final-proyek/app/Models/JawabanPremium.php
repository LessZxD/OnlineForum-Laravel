<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPremium extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'jawabanPremium';

    // Kolom yang dapat dimanipulasi (CRUD)
    protected $fillable = ['judul', 'konten', 'image', 'users_id', 'premium_id'];
}
