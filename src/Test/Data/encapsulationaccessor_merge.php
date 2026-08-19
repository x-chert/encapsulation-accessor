<?php

declare(strict_types=1);

use Xchert\Encapsulation\ArrayEncapsulation;
use Xchert\PropertyAccess\Exception\InvalidInputException;
use Xchert\PropertyAccess\Test\Classes\PropertyEncapsulationDemo;
use Xchert\Util\Exception\InvalidTypeException;

return (function (): Generator {
    yield from [
        'SimpleMergeArrayEncapsulation' => [
            'data' => new ArrayEncapsulation([
                'a' => 'first letter',
                'b' => 'second letter',
            ]),
            'value' => new ArrayEncapsulation([
                'b' => 'b is indeed the second letter',
                'c' => 'third letter',
                'd' => 'fourth letter',
            ]),
            'expected' => new ArrayEncapsulation([
                'a' => 'first letter',
                'b' => 'b is indeed the second letter',
                'c' => 'third letter',
                'd' => 'fourth letter',
            ]),
            'expectedException' => null,
            'flags' => []
        ],
        'SimpleMergePropertyEncapsulation' => [
            'data' => new PropertyEncapsulationDemo([
                'foo' => 'first letter',
                'bar' => 'second letter',
            ]),
            'value' => new PropertyEncapsulationDemo([
                'foo' => 'first letter',
                'bar' => 'another value for bar',
            ]),
            'expected' => new PropertyEncapsulationDemo([
                'foo' => 'first letter',
                'bar' => 'another value for bar',
            ]),
            'expectedException' => null,
            'flags' => []
        ],
        'DeepMerge' => [
            'data' => new ArrayEncapsulation([
                'letters' => new ArrayEncapsulation(['a' => 'a', 'b' => 'b']),
                'numbers' => new ArrayEncapsulation(['one' => 1, 'two' => 2]),
                'scalar' => 'a scalar value',
            ]),
            'value' => new ArrayEncapsulation([
                'letters' => new ArrayEncapsulation(['b' => 'b']),
                'numbers' => new ArrayEncapsulation(['two' => 22, 'three' => 33]),
                'scalar' => 'another scalar value',
            ]),
            'expected' => new ArrayEncapsulation([
                'letters' => new ArrayEncapsulation(['a' => 'a', 'b' => 'b']),
                'numbers' => new ArrayEncapsulation(['one' => 1, 'two' => 22, 'three' => 33]),
                'scalar' => 'another scalar value',
            ]),
            'expectedException' => null,
            'flags' => []
        ],
        'InvalidInputException' => [
            'data' => new ArrayEncapsulation(),
            'value' => 'not mergeable',
            'expected' => null,
            'expectedException' => InvalidInputException::class,
            'flags' => []
        ],
        'InvalidTypeException' => [
            'data' => new stdClass(),
            'value' => null,
            'expected' => null,
            'expectedException' => InvalidTypeException::class,
            'flags' => []
        ]
    ];
})();