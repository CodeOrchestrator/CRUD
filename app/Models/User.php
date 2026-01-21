<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'email_verification_code',
        'email_verification_code_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verification_code_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getGuardName(): string
    {
        return 'sanctum';
    }

    public function generateEmailVerificationCode(): string|null
    {
        $this->email_verification_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->email_verification_code_expires_at = now()->addMinutes(2);
        $this->save();
        return $this->email_verification_code;
    }

    public function markEmailAsVerifiedWithCode(): void
    {
        $this->email_verified_at = now();
        $this->email_verfication_code = null;
        $this->email_verfication_code_expires_at = null;
        $this->save();
    }

    public function isValidVerificationCode($code): bool
    {
        return $this->email_veerification_code == $code && $this->email_verification_code_expires_at &&
            $this->email_verification_code_expires_at->isFuture() ;
    }

    public function getMyRoleAttribute(): ?string
    {
        return $this->roles()->pluck('name')->first();
    }

    public function getMyRole(): ?string
    {
        return $this->roles()->pluck('name')->first();
    }




}
