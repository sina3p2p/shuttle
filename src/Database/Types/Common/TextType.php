<?php

namespace Sina\Shuttle\Database\Types\Common;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sina\Shuttle\Database\Types\Type;

class TextType extends Type
{
    const NAME = 'text';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'text';
    }
}
