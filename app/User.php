<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'job_title', 'email', 'password', 'department_id', 'profile_photo'
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
    public function department()
    {
        return $this->belongsTo(\App\Department::class);
    }

    public function purchase_order_requests(){
        return $this->hasMany('App\PurchaseOrderRequest');
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Role::class);
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
       
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function hasSuperuserRole()
    {
        return $this->hasRole('Superuser');
    }

    public function hasAdminRole()
    {
        return $this->hasRole('Admin');
    }

    public function hasSeniorManagerRole()
    {
        return $this->hasRole('Senior Manager');
    }

    public function hasManagerRole()
    {
        return $this->hasRole('Manager');
    }
    
    public function hasUserRole()
    {
        return $this->hasRole('User');
    }

    public static function getManagers(int $department_id)
    {
        return  DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->where([['roles.name', 'Manager'], ['users.department_id', $department_id]])->select('users.*')->get();
    }

    public static function getSeniorManagers(int $department_id)
    {
        return  DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->where([['roles.name', 'Manager'], ['users.department_id', $department_id]])->select('users.*')->get();
    }

    public function myPurchaseOrders()
    {
        return  \App\PurchaseOrderRequest::where('user_id', $this->id)->orderBy('id', 'DESC')->limit(5)->get();
    }

    public function allMyPurchaseOrders()
    {
        return \App\PurchaseOrderRequest::where('user_id', $this->id)->orderBy('id', 'DESC')->get();
    }

    public function myApprovedPurchaseOrders()
    {
        return  \App\PurchaseOrderRequest::where('user_id', $this->id)
        ->where('approved_by_admin', 'Approved')
        ->orderBy('id', 'DESC')->limit(5)->get();
    }

}
