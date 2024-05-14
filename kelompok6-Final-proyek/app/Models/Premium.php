<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    protected $table = 'premium';

    // Kolom yang dapat dimanipulasi (CRUD)
    protected $fillable = ['judul', 'konten', 'image', 'users_id', 'category_id'];
}
