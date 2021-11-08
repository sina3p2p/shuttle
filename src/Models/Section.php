<?php

namespace Sina\Shuttle\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $table = "shuttle_sections";
    protected $fillable = ['breadcrumb','type_id','position', 'model', 'body'];
    protected $casts = ['model' => 'json'];

//    public function components()
//    {
//        return $this->belongsToMany('Sina\Shuttle\Models\Component','section_component')->using('Sina\Shuttle\Models\SectionComponent')->withPivot('setting','component_id','locale','id')->orderBy('position');
//    }

    public function page()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Page');
    }

    public function type()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Type');
    }
}
