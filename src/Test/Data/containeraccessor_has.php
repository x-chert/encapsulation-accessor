<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'ValidPath' => [
            'data' => new Container(['foo', 'bar']),
            'field' => '0',
            'expected' => true,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathKey' => [
            'data' => new Container(['foo', 'bar']),
            'field' => 'nonexistingproperty',
            'expected' => false,
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidPathIndex' => [
            'data' => new Container(['foo', 'bar']),
            'field' => '3',
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