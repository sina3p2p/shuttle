<?php

namespace App\Sina\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Sina\Database\Types\Type;

class UuidType extends Type
{
    const NAME = 'uuid';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'uuid';
    }
}
