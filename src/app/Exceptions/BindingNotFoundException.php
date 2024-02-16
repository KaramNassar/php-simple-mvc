<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class BindingNotFoundException extends Exception
    implements NotFoundExceptionInterface
{

}
