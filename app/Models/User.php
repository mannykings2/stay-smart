<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone_number',
        'password',
        'email_verified_at',
        'id_verified_at',
        'is_guest',
        'role',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serializati
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
        'id_verified_at' => 'datetime',
    ];

    public function managedCleaners()
    {
        return $this->belongsToMany(User::class, 'admin_cleaner', 'admin_id', 'cleaner_id')->withTimestamps();
    }

    public function managingAdmins()
    {
        return $this->belongsToMany(User::class, 'admin_cleaner', 'cleaner_id', 'admin_id')->withTimestamps();
    }

    public function assignedProperties()
    {
        return $this->belongsToMany(Property::class, 'property_user')
            ->withPivot('role_type')->withTimestamps();
    }

    public function ownedProperties()
    {
        return $this->hasMany(Property::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookmarkedProperties()
    {
        return $this->belongsToMany(Property::class, 'property_bookmarks', 'user_id', 'property_id')
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function revenueSplits()
    {
        return $this->hasMany(RevenueSplit::class, 'admin_id');
    }

    public function revenuePayouts()
    {
        return $this->hasMany(RevenuePayout::class, 'admin_id');
    }

    public function revenueConfig()
    {
        return $this->hasOne(AdminRevenueConfig::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(AdminBankAccount::class);
    }

    public function idVerifications()
    {
        return $this->hasMany(IdVerification::class);
    }

    public function latestIdVerification()
    {
        return $this->hasOne(IdVerification::class)->latestOfMany();
    }

    /**
     * Check if the user has a verified ID.
     */
    public function isIdVerified()
    {
        return !is_null($this->id_verified_at);
    }

    /**
     * Get or create the revenue config for this user.
     */
    public function getOrCreateRevenueConfig()
    {
        return $this->revenueConfig ?? $this->revenueConfig()->create(['user_id' => $this->id]);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }
}
