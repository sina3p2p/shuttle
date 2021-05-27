<?php

namespace App\Sina\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Sina\Database\Types\Type;

class MacAddrType extends Type
{
    const NAME = 'macaddr';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'macaddr';
    }
}
