<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Format4Testing.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Formatting;

class Format4Testing
{
    private const MAX_COLUMN_WIDTH = 40;

    /**
     * @param array<array-key,array<array-key,mixed>> $table
     * @return string
     * @throws \JsonException
     */
    public static function toTableString(array $table): string
    {
        /** @var list<non-negative-int> $maxLengths */
        $maxLengths = [];
        foreach ($table as $row) {
            \assert(\is_array($row));
            $index = 0;
            foreach ($row as $column) {
                $value = self::toString($column);
                $length = \mb_strlen($value);
                if ($length > ($maxLengths[$index] ?? 0)) {
                    $maxLengths[$index] = $length;
                }
                $index++;
            }
        }
        $string = '';
        $newline = '';
        foreach ($table as $row) {
            $line = '';
            $index = 0;
            $separator = '';
            foreach ($row as $column) {
                $max = min(self::MAX_COLUMN_WIDTH, $maxLengths[$index]);
                $column = self::toString($column);
                $length = \mb_strlen($column);
                if ($length > $max) {
                    $column = \mb_substr($column, 0, $max - 3).'...';
                }
                $line .= $separator.\mb_str_pad($column, $max);
                $separator = ' ';
                $index++;
            }
            $string .= $newline.$line;
            $newline = \PHP_EOL;
        }

        return $string;
    }

    /**
     * @param array<array-key,mixed> $array
     * @return string
     * @throws \JsonException
     */
    private static function arrayToString(array $array): string
    {
        $string = '';
        $separator = '';
        foreach ($array as $key => $value) {
            $string .= $separator.self::toString($key).'=>'.self::toString($value);
            $separator = ', ';
        }

        return $string;
    }

    /**
     * @param object $object
     * @return non-empty-string
     */
    public static function toClassName(object $object): string
    {
        // @phpstan-ignore return.type
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @param mixed $value
     * @return string
     * @throws \JsonException
     */
    public static function toString(mixed $value): string
    {
        /** @noinspection PhpMultipleClassDeclarationsInspection */
        return match (\gettype($value)) {
            'array' => '['.self::arrayToString($value).']',
            'boolean' => $value ? 'true' : 'false',
            'double' => $value.((\floor($value) === $value) ? '.0' : ''),
            'integer' => (string)$value,
            'string' => '"'.$value.'"',
            'object' => match (true) {
                $value instanceof \BackedEnum => self::toClassName($value).'::'.$value->name.'='.$value->value,
                $value instanceof \UnitEnum => self::toClassName($value).'::'.$value->name,
                $value instanceof \DateTimeInterface => $value->format(\DateTimeInterface::ATOM),
                $value instanceof \DateTimeZone => $value->getName(),
                $value instanceof \DateInterval => $value->format('%R%a days, %h hours, %i minutes and %s seconds'),
                $value instanceof \JsonSerializable => (string)\json_encode($value, \JSON_THROW_ON_ERROR),
                $value instanceof \Throwable => $value->getMessage(),
                // @phpstan-ignore cast.string
                \method_exists($value, 'toString') => (string)$value->toString(),
                $value instanceof \Stringable => (string)$value,
                default => 'object'
            },
            // @phpstan-ignore greaterOrEqual.alwaysTrue
            'resource' => \get_resource_type($value).(PHP_VERSION_ID >= 80000 ? ' (id:'.\get_resource_id($value).')' : ''),
            'resource (closed)' => \get_resource_type($value),
            'NULL' => 'null',
            'unknown type' => 'n/a',
        };
    }
}
