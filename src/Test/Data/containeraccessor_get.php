<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Encapsulation\MutableContainer;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\PropertyAccess\Flags;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPathContainer' => [
            'data' => new Container(['foo', 'bar']),
            'field' => '0',
            'expected' => 'foo',
            'expectedException' => null,
            'flags' => []
        ],
        'ValidPathMutableontainer' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '0',
            'expected' => 'foo',
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathKey' => [
            'data' => new Container(['foo', 'bar']),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathIndex' => [
            'data' => new Container(['foo', 'bar']),
            'field' => '3',
            'expected' => null,
            'expectedException' => null,
            'flags' => []
        ],
        'StrictInvalidPathKey' => [
            'data' => new Container(['foo', 'bar']),
            'field' => 'nonexistingproperty',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'StrictInvalidPathIndex' => [
            'data' => new Container(['foo', 'bar']),
            'field' => '3',
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