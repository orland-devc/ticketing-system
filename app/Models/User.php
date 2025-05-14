<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'user_code',
        'student_id',
        'name',
        'email',
        'password',
        'google_id',
        'course',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_activity' => 'datetime',

    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->user_code = $user->generateUserCode();
        });
    }

    public function generateUserCode(): string
    {
        $encodedTime = base_convert(now()->format('dH'), 10, 36);
        $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
        $userCode = "USR{$encodedTime}{$randomCode}";

        return $this->userExists($userCode) ? $this->generateUserCode() : $userCode;
    }

    private function userExists(string $userCode): bool
    {
        return User::where('user_code', $userCode)->exists();
    }

    public function username()
    {
        return $this->role === 'Student' ? 'student_id' : 'email';
    }

    public function sentReplies()
    {
        return $this->hasMany(TicketReply::class, 'sender_id');
    }

    public function receivedReplies()
    {
        return $this->hasMany(TicketReply::class, 'assigned_to_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function isOnline()
    {
        return Cache::get('user-is-online-'.$this->id, false);
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    public function last_login_at()
    {
        return $this->hasOne(ActivityLog::class)
            ->where('type', 'login')
            ->latest();
    }
}
