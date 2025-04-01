<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoBank extends Model
{
    use HasFactory;

    protected $table = 'info_bank';

    protected $fillable = ['information', 'author'];
}
