<?php

namespace App\Sina\Database\Types\Postgresql;

use App\Sina\Database\Types\Common\DoubleType;

class DoublePrecisionType extends DoubleType
{
    const NAME = 'double precision';
    const DBTYPE = 'float8';
}
