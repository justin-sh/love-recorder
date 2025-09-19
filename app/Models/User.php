<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property string name
 * @property string email
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
        ];
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)->withPivot('id')->using(GroupUser::class);
    }

    public function group(): Group
    {
        return $this->groups()->where('group_id', Tenant::getRawId())->first();
    }

    public function roles(): BelongsToMany
    {
        return $this->group()->pivot->roles();
    }

    public function isDev(): bool
    {
        return $this->roles()->where('name', RoleName::DEV->value)->first() != null;
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', RoleName::ADMIN->value)->first() != null;
    }

    public function isAdminOrDev(): bool
    {
        return $this->roles()->whereIn('name', [RoleName::ADMIN->value, RoleName::DEV->value])->first() != null;
    }

    public function isGroupAdmin(): bool
    {
        return $this->roles()->where('name', RoleName::GROUP_ADMIN->value)->first() != null;
    }

    public function isGroupMember(): bool
    {
        return $this->roles()->where('name', RoleName::GROUP_MEMBER->value)->first() != null;
    }

    public function isGroupGuest(): bool
    {
        return $this->roles()->where('name', RoleName::GROUP_GUEST->value)->first() != null;
    }
}
