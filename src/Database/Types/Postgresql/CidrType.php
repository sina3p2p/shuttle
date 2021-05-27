<?php

namespace App\Sina\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Sina\Database\Types\Type;

class CidrType extends Type
{
    const NAME = 'cidr';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'cidr';
    }
}
