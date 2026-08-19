<?php

declare(strict_types=1);

namespace Xchert\PropertyAccess\Test\Classes;

use Xchert\Encapsulation\EncapsulatedProperties;

class EncapsulatedPropertiesDemo extends EncapsulatedProperties
{
    private string $foo;

    private string $bar = 'bar';

    private array $items = [];
}