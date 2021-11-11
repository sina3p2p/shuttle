<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Sina\Shuttle\Models\Nestable\NodeTrait;

class MenuItem extends Model
{
    use Translatable;
    use NodeTrait;

    public $table = "shuttle_menu_items";
    protected $guarded = ['id'];
    protected $translatedAttributes = ['title'];
    public $translationModel = 'Sina\Shuttle\Models\MenuItemTranslation';

    public $appends = ['label', 'link', 'image'];

    public function getLabelAttribute()
    {
        return $this->menuable ? $this->menuable[app($this->menuable_type)->shuttle_menu[1]] : $this->title;
    }
    
    public function getLinkAttribute()
    {
        return $this->menuable ? $this->menuable[app($this->menuable_type)->shuttle_menu[0]] : $this->url;
    }
    
    public function getImageAttribute()
    {
        return $this->menuable  && isset(app($this->menuable_type)->shuttle_menu[3]) ? $this->menuable->{app($this->menuable_type)->shuttle_menu[3]} : $this->icon;
    }

    public function children()
    {
        return $this->hasMany('Sina\Shuttle\Models\MenuItem','pid','id')->with('menuable')->orderBy('lft');
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
