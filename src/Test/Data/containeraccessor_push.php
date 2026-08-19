<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Encapsulation\MutableContainer;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'Push' => [
            'data' => new MutableContainer(['a', 'b', 'c']),
            'value' => 'd',
            'expected' => new MutableContainer(['a', 'b', 'c', 'd']),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidTypeExceptionObject' => [
            'data' => new stdClass(),
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ],
        'InvalidTypeExceptionContainer' => [
            'data' => new Container(),
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();