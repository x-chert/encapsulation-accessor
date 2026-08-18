<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'Collect' => [
            'data' => new Container([1, 2, 3]),
            'expected' => [1, 2, 3],
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidTypeException' => [
            'data' => new stdClass(),
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();