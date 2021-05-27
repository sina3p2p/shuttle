<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PageComponent extends Pivot
{
    protected $fillable = ['setting', 'locale', 'position'];

    protected $casts = ['setting' => 'json'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->position = static::where('page_id',$model->page_id)->where('locale', $model->locale)->max('position') + 1;
        });
    }

    public function component()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Component');
    }

    public function page()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Page');
    }
}
