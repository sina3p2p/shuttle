<?php

namespace Sina\Shuttle\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
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

    public function getAvatarAttribute()
    {
        return $this->image ? Storage::url($this->image) : 'https://cutewallpaper.org/24/space-shuttle-png/space-shuttle-launch-png-transparent-clipart-world.png';
    }
}
