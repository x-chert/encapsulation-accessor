<?php

declare(strict_types=1);

namespace Xchert\PropertyAccess\Test\Data;

class EncapsulationAccessorDataProvider
{
    public static function encapsulationaccessor_get(): iterable
    {
        return static::readFile(__DIR__.'/encapsulationaccessor_get.php');
    }

    public static function encapsulationaccessor_set(): iterable
    {
        return static::readFile(__DIR__.'/encapsulationaccessor_set.php');
    }

    public static function encapsulationaccessor_merge(): iterable
    {
        return static::readFile(__DIR__.'/encapsulationaccessor_merge.php');
    }

    public static function encapsulationaccessor_has(): iterable
    {
        return static::readFile(__DIR__.'/encapsulationaccessor_has.php');
    }

    public static function containeraccessor_get(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_get.php');
    }

    public static function containeraccessor_set(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_set.php');
    }

    public static function containeraccessor_merge(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_merge.php');
    }

    public static function containeraccessor_has(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_has.php');
    }

    public static function containeraccessor_push(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_push.php');
    }

    public static function containeraccessor_collect(): iterable
    {
        return static::readFile(__DIR__.'/containeraccessor_collect.php');
    }

    public static function readFile(string $file): iterable
    {
        if (!\file_exists($file) || !\is_readable($file)) {
            throw new \RuntimeException(\sprintf('File %s does not exist or is not readable.', $file));
        }

        return require $file;
    }
}