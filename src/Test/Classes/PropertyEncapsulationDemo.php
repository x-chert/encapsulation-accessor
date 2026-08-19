<?php

declare(strict_types=1);

namespace Xchert\PropertyAccess\Test\Classes;

use Xchert\Encapsulation\PropertyEncapsulation;

class PropertyEncapsulationDemo extends PropertyEncapsulation
{
    private string $foo;

    private string $bar = 'bar';

    private array $items = [];
}