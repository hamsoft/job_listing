<?php

namespace JobListing\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JobListing\Contracts\CurrentUser;

/**
 * JobListing\Entities\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \JobListing\Entities\Company $company
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\User whereUpdatedAt($value)
 */
class User extends Authenticatable implements CurrentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getId() {
        return $this->id;
    }

    public function company(){
        return $this->hasOne(Company::class, 'manager_id');
    }

    public function getCompany() {
        return $this->company;
    }
}
