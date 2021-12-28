<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Sina\Shuttle\Models\Nestable\NodeTrait;
use Illuminate\Database\Eloquent\Builder;

class MenuItem extends Model
{
    use Translatable;
    use NodeTrait;

    public $table = "shuttle_menu_items";
    protected $guarded = ['id'];
    protected $translatedAttributes = ['title'];
    public $translationModel = 'Sina\Shuttle\Models\MenuItemTranslation';

    public $appends = ['label', 'link', 'image'];

    protected static function booted()
    {
        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->orderBy('lft');
        });
    }

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
        if($this->menuable)
        {
            $shuttle_menu = app($this->menuable_type)->shuttle_menu;
            if(is_array($shuttle_menu) && isset($shuttle_menu[2]))
            {
                return $this->menuable[$shuttle_menu[2]];
            }
        }

        return $this->icon;
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
