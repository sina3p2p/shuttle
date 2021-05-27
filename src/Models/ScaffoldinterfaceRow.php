<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class ScaffoldinterfaceRow extends Model
{

    protected $table = "scaffold_interface_rows";
    public $timestamps = false;

    protected $fillable = [
        'scaffold_interface_id', 'field', 'type', 'display_name',
        'required', 'browse', 'read', 'edit', 'add', 'delete', 'details', 'ord'
    ];

//    protected $casts = [
//        'details' => 'json'
//    ];
}
