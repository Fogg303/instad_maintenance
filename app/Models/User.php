<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'direction_id',
        'force_password_change',
        'password_changed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'force_password_change' => 'boolean',
        'password_changed_at' => 'datetime',
    ];

    protected $dates = [
        'password_changed_at'
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'technician_id');
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::needsRehash($value) 
                ? Hash::make($value) 
                : $value;
        }
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
    
    public function needsPasswordChange()
    {
        return is_null($this->password_changed_at);
    }

    public function mustChangePassword(): bool
    {
        return $this->force_password_change || is_null($this->password_changed_at);
    }

    public function sendTemporaryPasswordNotification($tempPassword): void
    {
        $this->notify(new \App\Notifications\TemporaryPasswordNotification($tempPassword));
    }
}