<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastActivity extends Model
{
    use HasFactory;

    protected $fillable = ['last_activity', 'other_field'];

    public function isOnline()
    {
        // $threshold = now()->subMinutes(5); // Consider online if activity within the last 5 minutes
        // return $this->last_activity > $threshold;
    }
}
