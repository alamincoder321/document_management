<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
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
    ];


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->select('id', 'name');
    }

    public static function checkGroupName($group, $access)
    {
        $check = false;
        $permission = Permission::where('group_name', $group)->get()->pluck('permission');
        $accessAll = $access->where('group_name', $group);
        if (count($permission) == count($accessAll)) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }
    public static function checkAll($access)
    {
        $check = false;
        $permission = Permission::get();
        if (count($permission) == count($access)) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }
}
