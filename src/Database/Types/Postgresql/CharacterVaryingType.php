<?php

namespace App\Sina\Database\Types\Postgresql;

use App\Sina\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
