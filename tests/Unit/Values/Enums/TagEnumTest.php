<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TagEnumTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:42
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Enums;

use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TagEnum::class)]
class TagEnumTest extends TestCase
{
    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestData(): array
    {
        $openMemory = \fopen('php://memory', 'rb');
        $closedMemory = \fopen('php://memory', 'rb');
        if (false !== $closedMemory) {
            \fclose($closedMemory);
        }

        return [
            [[], TagEnum::ARRAY],
            [true, TagEnum::BOOLEAN],
            [1.2, TagEnum::FLOAT],
            [1, TagEnum::INTEGER],
            [null, TagEnum::NULL],
            [new \stdClass(), TagEnum::OBJECT],
            [$openMemory, TagEnum::RESOURCE],
            [$closedMemory, TagEnum::CLOSED_RESOURCE],
            ['abc', TagEnum::STRING],
        ];
    }

    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestDataForIsMine(): array
    {
        return [
            [true, TagEnum::ARRAY, [1]],
            [true, TagEnum::BOOLEAN, true],
            [true, TagEnum::CAPITAL_LETTER, 'A'],
            [true, TagEnum::CHAR, 'A'],
            [false, TagEnum::CLOSED_RESOURCE, 'x'],
            [true, TagEnum::DATETIME, new \DateTime('now')],
            [true, TagEnum::DIGIT, '1'],
            [true, TagEnum::DOMAIN, 'example.org'],
            [true, TagEnum::EMAIL, 'user@example.org'],
            [true, TagEnum::EMPTY, ''],
            [true, TagEnum::ENUM, Enum4Testing::ONE],
            [true, TagEnum::ENUM_INT, IntEnum4Testing::ONE],
            [true, TagEnum::ENUM_STRING, StringEnum4Testing::ONE],
            [true, TagEnum::EXCEPTION, new \Exception('test')],
            [true, TagEnum::FLOAT, 1.2],
            [true, TagEnum::FLOAT_NEGATIVE, -1.2],
            [true, TagEnum::FLOAT_NOT_NEGATIVE, 0.0],
            [true, TagEnum::FLOAT_POSITIVE, 1.2],
            [true, TagEnum::FLOAT_WITH_INT_VALUE, 1.0],
            [true, TagEnum::INTEGER, 1],
            [true, TagEnum::INTEGER_NEGATIVE, -1],
            [true, TagEnum::INTEGER_NOT_NEGATIVE, 0],
            [true, TagEnum::INTEGER_POSITIVE, 1],
            [true, TagEnum::IP_ADDRESS, 1],
            [false, TagEnum::IP_ADDRESS, '1'],
            [true, TagEnum::IP_ADDRESS, '127.0.0.1'],
            [true, TagEnum::IPv4, '127.0.0.1'],
            [true, TagEnum::IPv6, '2001:0db8:85a3:0000:0000:8a2e:0370:7334'],
            [true, TagEnum::IPv6, '::1'],
            [true, TagEnum::LETTER, 'a'],
            [true, TagEnum::MAC, '00:1A:2B:3C:4D:5E'],
            [true, TagEnum::NULL, null],
            [true, TagEnum::OBJECT, new \stdClass()],
            [false, TagEnum::PRIME, -1],
            [true, TagEnum::PRIME, 3],
            [false, TagEnum::PRIME, 6],
            [true, TagEnum::PRIME, 7],
            [false, TagEnum::PRIME, 35],
            [true, TagEnum::RESOURCE, STDOUT],
            [true, TagEnum::SMALL_LETTER, 'a'],
            [true, TagEnum::STRING, 'abc'],
            [true, TagEnum::STRING_FLOAT, '1.2'],
            [true, TagEnum::STRING_INTEGER, '1'],
            [true, TagEnum::STRING_LOWER, 'abc'],
            [true, TagEnum::STRING_NUMERIC, '123'],
            [true, TagEnum::STRING_UPPER, 'ABC'],
            [true, TagEnum::URL, 'https://example.org'],

        ];
    }

    /**
     * @param mixed $data
     * @param TagEnum $enum
     * @return void
     * @dataProvider provideTestData
     */
    public function testFromData(mixed $data, TagEnum $enum): void
    {
        self::assertEquals($enum, TagEnum::fromData($data));
    }

    /**
     * @param bool $isValid
     * @param TagEnum $tag
     * @param mixed $value
     * @return void
     * @dataProvider provideTestDataForIsMine
     */
    public function testIsMine(bool $isValid, TagEnum $tag, mixed $value): void
    {
        self::assertSame($isValid, $tag->isMine($value), $tag->name);
    }
}
