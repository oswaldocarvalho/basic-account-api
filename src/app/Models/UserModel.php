<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class UserModel extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Timestamps to verify inclusions and updates.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'nickname',
        'email',
        'password',
        'is_email_verified',
        'token'
    ];

    /**
     * Hidden attributes
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'is_email_verified',
        'created_at',
        'updated_at'
    ];
}
