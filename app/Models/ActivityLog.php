<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'type',
        'log_code',
        'description',
        'user_id',
        'user_type',
        'ticket_id', // Added ticket_id to fillable
        'additional_data',
        'ip_address',
    ];

    protected $casts = [
        'additional_data' => 'array',
    ];

    public function generateLogCode(): string
    {
        $encodedTime = base_convert(now()->format('dH'), 10, 36);
        $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
        $logId = "LOG{$encodedTime}{$randomCode}";

        return $this->logExists($logId) ? $this->generateLogCode() : $logId;
    }

    private function logExists(string $logId): bool
    {
        return ActivityLog::where('log_code', $logId)->exists();
    }

    /**
     * Get the user who performed the activity
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * Get the associated ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Create a new activity log
     *
     * @param  string  $type
     * @param  string  $description
     * @param  mixed  $user
     * @param  array  $additionalData
     * @param  mixed  $ticket
     * @return self
     */
    public static function log($type, $description, $user = null, $additionalData = [], $ticket = null)
    {
        return self::create([
            'type' => $type,
            'description' => $description,
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? get_class($user) : null,
            'ticket_id' => $ticket ? $ticket->id : null, // Added ticket_id
            'additional_data' => $additionalData,
            'ip_address' => request()->ip(),
        ]);
    }
}
