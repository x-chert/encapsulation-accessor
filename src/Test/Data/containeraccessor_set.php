<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Encapsulation\MutableContainer;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\PropertyAccess\Flags;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPath' => [
            'data' => new MutableContainer(),
            'field' => '0',
            'value' => 'foo',
            'expected' => new MutableContainer(['foo']),
            'expectedException' => null,
            'flags' => []
        ],
        'ValidPathOverwrite' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '1',
            'value' => 'updated value',
            'expected' => new MutableContainer(['foo', 'updated value']),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathKey' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => new MutableContainer(['foo', 'bar']),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathNegativeIndex' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '-1',
            'value' => 'some value',
            'expected' => new MutableContainer(['foo', 'bar']),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathOutOfRange' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '3',
            'value' => 'some value',
            'expected' => new MutableContainer(['foo', 'bar']),
            'expectedException' => null,
            'flags' => []
        ],
        'StrictInvalidPathKey' => [
            'data' => new MutableContainer(),
            'field' => 'nonexistingproperty',
            'value' => 'some value',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'StrictInvalidPathNegativeIndex' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '-1',
            'value' => 'some value',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'StrictInvalidPathOutOfRange' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'field' => '3',
            'value' => 'some value',
            'expected' => null,
            'expectedException' => PropertyNotFoundException::class,
            'flags' => [Flags::STRICT]
        ],
        'InvalidTypeException' => [
            'data' => new stdClass(),
            'field' => 'some field',
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ],
        'InvalidTypeExceptionContainer' => [
            'data' => new Container(),
            'field' => 'some field',
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ],
    ];
})();