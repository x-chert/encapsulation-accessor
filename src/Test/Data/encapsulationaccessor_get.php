<?php

declare(strict_types=1);

use Xchert\Encapsulation\EncapsulatedArray;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\PropertyAccess\Flags;
use Xchert\PropertyAccess\Test\Classes\EncapsulatedPropertiesDemo;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPathEncapsulatedArray' => [
            'data' => new EncapsulatedArray(['foo' => 'bar']),
            'field' => 'foo',
            'expected' => 'bar',
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathEncapsulatedArray' => [
            'data' => new EncapsulatedArray(),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => null,
            'flags' => []
        ],
        'ValidPathEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(['foo' => 'fooValue']),
            'field' => 'foo',
            'expected' => 'fooValue',
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => null,
            'flags' => []
        ],
        'StrictInvalidPathEncapsulatedArray' => [
            'data' => new EncapsulatedArray(),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'StrictInvalidPathEncapsulatedProperties' => [
            'data' => new EncapsulatedPropertiesDemo(),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
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