<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Searchable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime'
    ];


    public function loginLogs() {
        return $this->hasMany(UserLogin::class);
    }

    public function investments() {
        return $this->hasMany(Investment::class)->orderBy('id', 'desc');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function referralCommissionWallet() {
        return $this->hasMany(ReferralCommissionWallet::class, 'user_id');
    }

    public function fullname(): Attribute {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    // SCOPES
    public function scopeActive($query) {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopeBanned($query) {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query) {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query) {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query) {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query) {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query) {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query) {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeReferralCount($query) {
        return $query->where('ref_by', $this->id)->count();
    }
}
