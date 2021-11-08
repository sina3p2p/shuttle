<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class ScaffoldinterfaceRow extends Model
{

    protected $table = "shuttle_scaffold_interface_rows";
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'details' => 'object'
    ];

    public function rowable()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

}
