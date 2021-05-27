<?php

namespace Sina\Shuttle\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    use \Spatie\Permission\Traits\HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'image', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
