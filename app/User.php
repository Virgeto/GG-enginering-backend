<?php


namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Base implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'profile_id',
        'profile_type',
        'password',
        'remember_token'
    ];

    /**
     * Get all of the owning userable models.
     */
    public function profile()
    {
        return $this->morphTo();
    }

    /**
     * Roles that belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Filter Users by Role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $role
     * @return mixed
     */
    public function scopeWhereHasRole($query, $role)
    {
        return $query->whereHas(
            'roles',
            function ($userQuery) use ($role) {
                $userQuery->where('name', $role);
            }
        );
    }

    /**
     * Associate profile with current user.
     *
     * @param $profile
     */
    public function associateProfile($profile)
    {
        if (!empty($profile)) {
            $this->profile()->associate($profile);
        }
    }
}
