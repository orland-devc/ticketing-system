<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'parent_message_id', 'sender_id', 'assigned_to_id', 'content'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function parentMessage()
    {
        return $this->belongsTo(TicketReply::class, 'parent_message_id');
    }

    public function childReplies()
    {
        return $this->hasMany(TicketReply::class, 'parent_message_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
