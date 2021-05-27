<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Sina\Shuttle\Models\Nestable\NodeTrait;

class MenuItem extends Model
{
    use Translatable;
    use NodeTrait;

    protected $fillable = ['pid','position','url','page_id','menu_id', 'menuable_type', 'menuable_id'];
    protected $translatedAttributes = ['title'];
    public $translationModel = 'Sina\Shuttle\Models\MenuItemTranslation';

//    public function menu()
//    {
//        return $this->belongsTo('Sina\Shuttle\Models\Menu');
//    }
//
//    public function page()
//    {
//        return $this->belongsTo('Sina\Shuttle\Models\Page');
//    }
//
    public function children()
    {
        return $this->hasMany('Sina\Shuttle\Models\MenuItem','pid','id')->with('menuable')->orderBy('ord');
    }

    public function menuable()
    {
        return $this->morphTo();
    }

    protected function getScopeAttributes()
    {
        return ['menu_id'];
    }
}
