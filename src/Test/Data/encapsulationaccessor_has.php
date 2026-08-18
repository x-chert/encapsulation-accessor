<?php

declare(strict_types=1);

use Xchert\Encapsulation\EncapsulatedArray;
use Xchert\PropertyAccess\Test\Classes\EncapsulatedPropertiesDemo;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPathEncapsulatedArray' => [
            'data' => new EncapsulatedArray(['foo' => 'bar']),
            'field' => 'foo',
            'expected' => true,
            'expectedException' => null,
            'flags' => []
        ],
        'ValidPathEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(),
            'field' => 'foo',
            'expected' => true,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathEncapsulatedArray' => [
            'data' => new EncapsulatedArray(),
            'field' => 'nonexistingproperty',
            'expected' => false,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(),
            'field' => 'nonexistingproperty',
            'expected' => false,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidTypeException' => [
            'data' => new stdClass(),
            'field' => 'some field',
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();