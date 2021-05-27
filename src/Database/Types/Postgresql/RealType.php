<?php

namespace App\Sina\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Sina\Database\Types\Type;

class RealType extends Type
{
    const NAME = 'real';
    const DBTYPE = 'float4';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
