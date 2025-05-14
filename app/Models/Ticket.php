<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'sender_id',
        'subject',
        'category',
        'content',
        'guest_name',
        'guest_birthday',
        'guest_email',
        'guest_tracking_token',
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->ticket_code = $ticket->generateTicketId();
        });
    }

    public function generateTicketId(): string
    {
        $encodedTime = base_convert(now()->format('dH'), 10, 36);
        $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
        $ticketId = "TKT{$encodedTime}{$randomCode}";

        return $this->ticketExists($ticketId) ? $this->generateTicketId() : $ticketId;
    }

    private function ticketExists(string $ticketId): bool
    {
        return Ticket::where('ticket_code', $ticketId)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function ticket()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function reply()
    {
        return $this->hasOne(TicketReply::class)->latest('created_at');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function returnToQueue(User $user, Ticket $ticket)
    {
        return $ticket->assigned_to === Auth::user()->id;
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category', 'name');
    }

    // In app/Models/Ticket.php
    public function generateGuestTrackingToken()
    {
        do {
            $token = Str::random(16);
        } while (self::where('guest_tracking_token', $token)->exists());

        return $token;
    }

    public static function truncateWithRelations()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete related records
        TicketReply::query()->delete();
        Attachment::query()->delete();

        // Now truncate the table
        self::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
