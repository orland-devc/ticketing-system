<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'ticket_id',
        'ticket_reply_id',
        'message_id',
        'file_name',
        'file_location',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function message()
    {
        return $this->belongsTo(Messages::class);
    }

    public function ticket_reply()
    {
        return $this->belongsTo(TicketReply::class);
    }

    public function getSize()
    {
        if (file_exists($this->file_location)) {
            return filesize($this->file_location);
        }

        return 0;
    }

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return asset($this->file_location);
    }
}
