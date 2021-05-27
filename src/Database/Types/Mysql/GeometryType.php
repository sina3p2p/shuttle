<?php

namespace Sina\Shuttle\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sina\Shuttle\Database\Types\Type;

class GeometryType extends Type
{
    const NAME = 'geometry';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'geometry';
    }
}
