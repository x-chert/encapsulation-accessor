<?php

namespace Xchert\PropertyAccess;

use Xchert\Encapsulation\Container;
use Xchert\Encapsulation\MutableContainer;
use Xchert\PropertyAccess\Exception\InvalidInputException;
use Xchert\PropertyAccess\Exception\InvalidPathException;
use Xchert\PropertyAccess\Exception\OperationNotSupportedException;
use Xchert\PropertyAccess\Exception\PropertyNotFoundException;
use Xchert\Util\Exception\InvalidTypeException;
use Xchert\Util\Type;

class ContainerAccessor extends Accessor
{
    public const string ID = 'container';

    public function supports(Operation $operation, mixed $value): bool
    {
        if($value instanceof MutableContainer) {
            return \in_array(
                $operation,
                [
                    Operation::Get,
                    Operation::Set,
                    Operation::Has,
                    Operation::Merge,
                    Operation::Push,
                    Operation::Collect
                ]
            );
        }

        if($value instanceof Container) {
            return \in_array(
                $operation,
                [
                    Operation::Get,
                    Operation::Has,
                    Operation::Collect
                ]
            );
        }

        return false;
    }

    /**
     * @param Container $data
     *
     * @throws PropertyNotFoundException
     * @throws InvalidTypeException
     */
    public function get(string $field, mixed $data, AccessContext $context): mixed
    {
        Type::validate($data, Container::class);

        if(!$this->isIndexField($field)) {
            if($context->hasFlags(Flags::STRICT)) {
                throw new PropertyNotFoundException($context->getPath());
            }

            return null;
        }

        $data = \array_values($data->toArray());

        if(!\array_key_exists($field, $data)) {
            if($context->hasFlags(Flags::STRICT)) {
                throw new PropertyNotFoundException($context->getPath());
            }

            return null;
        }

        return $data[$field];
    }

    /**
     * @param MutableContainer $data
     *
     * @throws InvalidTypeException
     * @throws PropertyNotFoundException
     */
    public function set(string $field, mixed &$data, mixed $value, AccessContext $context): void
    {
        Type::validate($data, MutableContainer::class);

        if(!$this->isIndexField($field)) {
            if($context->hasFlags(Flags::STRICT)) {
                throw new PropertyNotFoundException($context->getPath());
            }

            return;
        }

        $field = (int) $field;

        if($field < 0 || $field > \count($data)) {
            if($context->hasFlags(Flags::STRICT)) {
                throw new PropertyNotFoundException($context->getPath());
            }

            return;
        }

        $data->splice($field, 1, [$value]);
    }

    /**
     * @param MutableContainer $data
     *
     * @throws InvalidTypeException
     */
    public function push(mixed &$data, mixed $value, AccessContext $context): void
    {
        Type::validate($data, MutableContainer::class);

        $data->add($value);
    }

    /**
     * @param Container $data
     *
     * @throws InvalidTypeException
     */
    public function collect(mixed $data, AccessContext $context): array
    {
        Type::validate($data, Container::class);

        return $data->toArray();
    }

    /**
     * @param Container $data
     *
     * @throws InvalidTypeException
     */
    public function has(string $field, mixed $data, AccessContext $context): bool
    {
        Type::validate($data, Container::class);

        if(!$this->isIndexField($field)) {
            return false;
        }

        $field = (int) $field;

        return \array_key_exists($field, $data->toArray());
    }

    /**
     * @param MutableContainer $data
     * @param mixed $value
     * @param AccessContext $context
     *
     * @throws InvalidInputException
     * @throws InvalidPathException
     * @throws OperationNotSupportedException
     * @throws InvalidTypeException
     * @throws PropertyNotFoundException
     */
    public function merge(mixed &$data, mixed $value, AccessContext $context): void
    {
        Type::validate($data, MutableContainer::class);

        $index = -1;

        /**
         * @var string|int $key
         * @var mixed $valueToMerge
         */
        foreach(Util::valueToMerge($value) as $key => $valueToMerge) {
            ++$index;

            if(!$context->hasFlags(ArrayAccessor::MERGE_OVERWRITE_NUMERIC)) {
                $this->push($data, $valueToMerge, $context);

                continue;
            }

            $subPath = $context->getPath()->copy()->add($key);

            if(!$this->isIndexField($key)) {
                if($context->hasFlags(Flags::STRICT)) {
                    throw new PropertyNotFoundException($subPath);
                }

                $key = $index;
            }

            $getContext = $context->subContext(Operation::Get, new Path([$key]));
            $getContext->removeFlag(Flags::STRICT);

            $dataValue = $this->get((string) $key, $data, $getContext);

            if(Util::isMergeable($dataValue) && Util::isMergeable($valueToMerge)) {
                $context->getPropertyAccessor()->write(
                    new Path(),
                    $dataValue,
                    $valueToMerge,
                    $context->subContext(Operation::Merge, new Path([$key]))
                );
                $this->set($key, $data, $dataValue, $context->subContext(Operation::Set, new Path([$key])));

                continue;
            }

            if($context->hasFlags(ArrayAccessor::MERGE_OVERWRITE_NUMERIC)) {
                $this->set($key, $data, $valueToMerge, $context);

                continue;
            }

            $this->push($data, $valueToMerge, $context);
        }
    }

    protected function isIndexField(string $field): bool
    {
        return (string) (int) $field === $field;
    }
}