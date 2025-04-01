<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignUpRequest extends Model
{
    use HasFactory;

    protected $table = 'sign_up_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'course',
        'year_level',
        'approved',
        'birthdate',
    ];
}
