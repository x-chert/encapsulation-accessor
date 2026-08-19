<?php

declare(strict_types=1);

use Xchert\Encapsulation\Container;
use Xchert\Encapsulation\MutableContainer;
use Xchert\PropertyAccess\ArrayAccessor;
use Xchert\PropertyAccess\Exception\InvalidInputException;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'NumericMerge' => [
            'data' => new MutableContainer(['a', 'b', 'c']),
            'value' => new Container(['d', 'e', 'f']),
            'expected' => new MutableContainer(['a', 'b', 'c', 'd', 'e', 'f']),
            'expectedException' => null,
            'flags' => []
        ],
        'OverwriteNumericMerge' => [
            'data' => new MutableContainer(['a', 'b', 'c']),
            'value' => new Container(['d', 'e', 'f']),
            'expected' => new MutableContainer(['d', 'e', 'f']),
            'expectedException' => null,
            'flags' => [ArrayAccessor::MERGE_OVERWRITE_NUMERIC]
        ],
        'MergeNoOverwriteNumeric' => [
            'data' => new MutableContainer([
                new MutableContainer(['a', 'b', 'c', 'd']),
                new MutableContainer([1, 2, 3, 4])
            ]),
            'value' => new Container([
                new Container(['e', 'f', 'g']),
                new Container([5, 6, 7])
            ]),
            'expected' => new MutableContainer([
                new MutableContainer(['a', 'b', 'c', 'd']),
                new MutableContainer([1, 2, 3, 4]),
                new Container(['e', 'f', 'g']),
                new Container([5, 6, 7])
            ]),
            'expectedException' => null,
            'flags' => []
        ],
        'DeepMergeOverwriteNumeric' => [
            'data' => new MutableContainer([
                new MutableContainer(['a', 'b', 'c', 'd']),
                new MutableContainer([1, 2, 3, 4])
            ]),
            'value' => new Container([
                new Container(['e', 'f', 'g']),
                new Container([5, 6, 7])
            ]),
            'expected' => new MutableContainer([
                new MutableContainer(['e', 'f', 'g', 'd']),
                new MutableContainer([5, 6, 7, 4]),
            ]),
            'expectedException' => null,
            'flags' => [ArrayAccessor::MERGE_OVERWRITE_NUMERIC]
        ],
        'InvalidInputException' => [
            'data' => new MutableContainer(['foo', 'bar']),
            'value' => 'not mergeable',
            'expected' => null,
            'expectedException' => InvalidInputException::class,
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
            'data' => new Container(['foo', 'bar']),
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();