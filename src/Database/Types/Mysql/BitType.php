<?php

namespace Sina\Shuttle\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sina\Shuttle\Database\Types\Type;

class BitType extends Type
{
    const NAME = 'bit';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        $length = empty($field['length']) ? 1 : $field['length'];
        $length = $length > 64 ? 64 : $length;

        return "bit({$length})";
    }
}
