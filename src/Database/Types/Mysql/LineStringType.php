<?php

namespace Sina\Shuttle\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sina\Shuttle\Database\Types\Type;

class LineStringType extends Type
{
    const NAME = 'linestring';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'linestring';
    }
}
