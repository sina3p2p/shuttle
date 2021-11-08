<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Translatable;

    public $table = "shuttle_pages";

    public $translationModel = 'Sina\Shuttle\Models\PageTranslation';

    public $translatedAttributes = ['title', 'keywords', 'description'];

    protected $fillable = ['url', 'type_id', 'image'];

    public function sections()
    {
        return $this->hasMany('Sina\Shuttle\Models\Section')->orderBy('position');
    }

    public function type()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Type')->with('sections');
    }

    public function scaffold()
    {
        return $this->hasOne('Sina\Shuttle\Models\Scaffoldinterface','model','model');
    }

    public function components()
    {
        return $this->belongsToMany('Sina\Shuttle\Models\Component','shuttle_page_component')->using('Sina\Shuttle\Models\PageComponent')->withPivot('setting','component_id','locale','id')->orderBy('position');
    }

    public function menu()
    {
        return $this->morphMany('Sina\Shuttle\Models\MenuItem', 'menuable');
    }
}
