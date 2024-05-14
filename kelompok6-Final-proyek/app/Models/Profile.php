<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    // Kolom yang dapat dimanipulasi (CRUD)
    protected $fillable = ['name', 'umur', 'alamat', 'users_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
