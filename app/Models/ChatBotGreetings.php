<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBotGreetings extends Model
{
    use HasFactory;

    protected $table = 'chatbot_greetings';

    protected $fillable = ['message'];
}
