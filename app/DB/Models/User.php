<?php

namespace App\DB\Models;

use App\DB\Filters\UserFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Leading\Lib\Eloquent\Traits\Filterable;

/**
 * Class User
 * @package App
 * @mixin Builder
 */
class User extends AuthUser
{
    use Notifiable, Filterable;

    /**
     * @var string
     */
    protected $filterClass = UserFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
