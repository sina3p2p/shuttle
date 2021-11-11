<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class ScaffoldInterface extends Model
{
    protected $table = "shuttle_scaffold_interfaces";

    protected $guarded = ['id'];

    public $shuttle_menu = ['slug', 'display_name_plural'];

    // public function rows()
    // {
    //     return $this->hasMany('Sina\Shuttle\Models\ScaffoldinterfaceRow', 'scaffold_interface_id', 'id')->orderBy('ord');
    // }

    public function rows()
    {
        return $this->morphMany(ScaffoldinterfaceRow::class, 'rowable');
    }
    
    public function browseRows()
    {
        return $this->rows()->where('browse', 1);
    }

    public function readRows()
    {
        return $this->rows()->where('read', 1);
    }

    public function editRows()
    {
        return $this->rows()->where('edit', 1);
    }

    public function addRows()
    {
        return $this->rows()->where('add', 1);
    }

}
