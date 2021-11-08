<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table = "shuttle_menus";

    protected $fillable = ['pid','position','url','page_id','type', 'name'];

    public function items()
    {
        return $this->hasMany('Sina\Shuttle\Models\MenuItem')->where('pid',0)->with(['children','menuable']);//->orderby('position');
    }

}
