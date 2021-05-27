<?php

namespace App\Sina\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Sina\Database\Types\Type;

class IntervalType extends Type
{
    const NAME = 'interval';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'interval';
    }
}
