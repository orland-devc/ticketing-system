<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBank extends Model
{
    use HasFactory;

    protected $table = 'data_bank';

    protected $fillable = ['chatPattern', 'chatResponse', 'author_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
