<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'jawaban';

    // Kolom yang dapat dimanipulasi (CRUD)
    protected $fillable = ['judul', 'konten', 'image', 'users_id', 'pertanyaan_id'];

}
