<?php

declare(strict_types=1);

use Xchert\Encapsulation\ArrayEncapsulation;
use Xchert\Encapsulation\EncapsulatedArray;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\PropertyAccess\Flags;
use Xchert\PropertyAccess\Test\Classes\ArrayEncapsulationChildWithAllowedFields;
use Xchert\PropertyAccess\Test\Classes\EncapsulatedPropertiesDemo;
use Xchert\PropertyAccess\Test\Classes\PropertyEncapsulationDemo;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPathArrayEncapsulation' => [
            'data' => new ArrayEncapsulation(),
            'field' => 'foo',
            'value' => 'bar',
            'expected' => new ArrayEncapsulation(['foo' => 'bar']),
            'expectedException' => null,
            'flags' => []
        ],
        'ValidPathPropertyEncapsulation' => [
            'data' => new PropertyEncapsulationDemo(),
            'field' => 'foo',
            'value' => 'bar',
            'expected' => new PropertyEncapsulationDemo(['foo' => 'bar']),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathArrayEncapsulation' => [
            'data' => new ArrayEncapsulationChildWithAllowedFields(),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => new ArrayEncapsulationChildWithAllowedFields(),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathPropertyEncapsulation' => [
            'data' => new PropertyEncapsulationDemo(),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => new PropertyEncapsulationDemo(),
            'expectedException' => null,
            'flags' => []
        ],
        'StrictInvalidPathPropertyEncapsulation' => [
            'data' => new PropertyEncapsulationDemo(),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'StrictInvalidPathArrayEncapsulation' => [
            'data' => new ArrayEncapsulationChildWithAllowedFields(),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'InvalidTypeExceptionObject' => [
            'data' => new stdClass(),
            'field' => 'some field',
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ],
        'InvalidTypeExceptionEncapsulatedArray' => [
            'data' => new EncapsulatedArray(),
            'field' => 'some field',
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ],
        'InvalidTypeExceptionEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(),
            'field' => 'some field',
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();