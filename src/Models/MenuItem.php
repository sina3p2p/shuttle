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
    protected $fillable = ['pid','position','url','menu_id', 'menuable_type', 'menuable_id'];
    protected $translatedAttributes = ['title'];
    public $translationModel = 'Sina\Shuttle\Models\MenuItemTranslation';

    public $appends = ['label', 'link'];

    public function getLabelAttribute()
    {
        return $this->menuable ? $this->menuable[array_values(app($this->menuable_type)->shuttle_menu)[0]] : $this->title;
    }
    
    public function getLinkAttribute()
    {
        return $this->menuable ? $this->menuable[array_keys(app($this->menuable_type)->shuttle_menu)[0]] : $this->url;
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
