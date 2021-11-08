<?php

namespace Sina\Shuttle\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;
    use \Spatie\Permission\Traits\HasRoles;

    // protected $guard = 'admin';

    public $table = "shuttle_admins";

    protected $fillable = [
        'name', 'image', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
