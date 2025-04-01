<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    protected $fillable = ['message_id', 'file_path', 'file_name', 'file_type'];

    public function message()
    {
        return $this->belongsTo(Chat::class);
    }

    use HasFactory;
}
