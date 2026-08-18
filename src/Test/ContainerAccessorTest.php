<?php

declare(strict_types=1);

namespace Xchert\PropertyAccess\Test;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Xchert\PropertyAccess\AccessContext;
use Xchert\PropertyAccess\ContainerAccessor;
use Xchert\PropertyAccess\Operation;
use Xchert\PropertyAccess\Path;
use Xchert\PropertyAccess\PropertyAccessor;
use Xchert\PropertyAccess\Test\Data\EncapsulationAccessorDataProvider;

class ContainerAccessorTest extends TestCase
{
    private ContainerAccessor $accessor;

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_get')]
    public function testGet(mixed $data, string $field, mixed $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Get);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $result = $this->accessor->get($field, $data, $context);

        if ($expectedException === null) {
            $this->assertEquals($expected, $result);
        }
    }

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_set')]
    public function testSet(mixed $data, string $field, mixed $value, mixed $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Set);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $this->accessor->set($field, $data, $value, $context);

        if ($expectedException === null) {
            $this->assertEquals($expected, $data);
        }
    }

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_merge')]
    public function testMerge(mixed $data, mixed $value, mixed $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Merge);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $this->accessor->merge($data, $value, $context);

        if ($expectedException === null) {
            $this->assertEquals($expected, $data);
        }
    }

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_has')]
    public function testHas(mixed $data, string $field, ?bool $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Has);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $result = $this->accessor->has($field, $data, $context);

        if ($expectedException === null) {
            $this->assertSame($expected, $result);
        }
    }

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_push')]
    public function testPush(mixed $data, mixed $value, mixed $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Merge);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $this->accessor->push($data, $value, $context);

        if ($expectedException === null) {
            $this->assertEquals($expected, $data);
        }
    }

    #[DataProviderExternal(EncapsulationAccessorDataProvider::class, 'containeraccessor_collect')]
    public function testCollect(mixed $data, mixed $expected, ?string $expectedException = null, array $flags = []): void
    {
        $context = $this->createContext($flags, Operation::Has);

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $result = $this->accessor->collect($data, $context);

        if ($expectedException === null) {
            $this->assertSame($expected, $result);
        }
    }

    protected function setUp(): void
    {
        $this->accessor = new ContainerAccessor();
    }

    private function createContext(array $flags, Operation $operation): AccessContext
    {
        $propertyAccessor = new PropertyAccessor();
        $propertyAccessor->registerAccessor($this->accessor, ContainerAccessor::ID, 0);

        return new AccessContext($operation, new Path(), $propertyAccessor, ...$flags);
    }
}