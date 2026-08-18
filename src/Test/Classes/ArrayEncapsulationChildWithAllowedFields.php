<?php

declare(strict_types=1);

namespace Xchert\PropertyAccess\Test\Classes;

use Xchert\Encapsulation\ArrayEncapsulation;

class ArrayEncapsulationChildWithAllowedFields extends ArrayEncapsulation
{
    public function isFieldAllowed(string $field): bool
    {
        return \in_array(
            $field,
            ['foo', 'bar']
        );
    }
}