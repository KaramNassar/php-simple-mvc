<?php

declare(strict_types=1);

namespace App\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{

    public function __construct(
        public string $path,
        public string $method = 'GET'
    ) {
    }

}