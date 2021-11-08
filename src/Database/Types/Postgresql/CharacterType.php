<?php

namespace App\Sina\Database\Types\Postgresql;

use App\Sina\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
