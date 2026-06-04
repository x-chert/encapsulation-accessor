<?php

namespace Xchert\PropertyAccess;

use Xchert\Encapsulation\Encapsulated;
use Xchert\Encapsulation\Encapsulation;
use Xchert\Encapsulation\Exception\NotAllowedFieldException;
use Xchert\Encapsulation\Exception\PropertyNotExistsException;
use Xchert\PropertyAccess\Exception\OperationNotSupportedException;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\Util\Type;

class EncapsulationAccessor extends Accessor
{
    public const string ID = 'encapsulation';

    public function supports(Operation $operation, mixed $value): bool
    {
        if($value instanceof Encapsulation) {
            return \in_array(
                $operation,
                [
                    Operation::Get,
                    Operation::Set,
                    Operation::Merge,
                    Operation::Has
                ]
            );
        }

        if($value instanceof Encapsulated) {
            return \in_array(
                $operation,
                [
                    Operation::Get,
                    Operation::Has,
                ]
            );
        }

        return false;
    }

    public function get(string $field, mixed $data, AccessContext $context): mixed
    {
        Type::validate($data, Encapsulated::class);

        if(!$data->has($field)) {
            if($context->hasFlags(Flags::STRICT)) {
                throw new PropertyNotFoundException($context->getPath());
            }

            return null;
        }

        return $data->get($field);
    }

    public function set(string $field, mixed &$data, mixed $value, AccessContext $context): void
    {
        Type::validate($data, Encapsulation::class);

        try {
            $data->set($field, $value);
        } catch(PropertyNotExistsException|NotAllowedFieldException $e) {
            if($context->hasFlags(Flags::STRICT)) {
                throw $e;
            }
        }
    }

    public function has(string $field, mixed $data, AccessContext $context): bool
    {
        Type::validate($data, Encapsulated::class);

        return $data->has($field);
    }

    public function push(mixed &$data, mixed $value, AccessContext $context): void
    {
        throw new OperationNotSupportedException(Operation::Push);
    }

    public function collect(mixed $data, AccessContext $context): array
    {
        throw new OperationNotSupportedException(Operation::Collect);
    }
}