<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'json', 'dob', 'phone', 'power', 'burstiq_private_id', 'site_id', 'benefit_affirmed_on', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Gets the first and last names from the saves json.
     * If there is no json, it will attempt to deduce the first and last names
     * @return array [$first_name, $last_name]
     */
    public function getFirstAndLastNames(){
        $json = $this->json ?? null;
        if ( (!empty($json)) and ($json = json_decode($json)) )
            return [$json->first_name, $json->last_name];

        //"Oh God No" fall back
        $a = explode(' ', $this->name, 2);
        if (count($a) == 1)
            $a[] = 'Nosurname';

        $a[0] = trim($a[0]);
        $a[1] = trim($a[1]);

        return $a;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace('’', "'", $value);
    }

    public function scopePatients($q)
    {
        return $q->join('role_user', function ($join) {
            $join->on('role_user.user_id', '=', 'users.id')
                ->where('role_user.role_id', 2);
        });
    }
}
