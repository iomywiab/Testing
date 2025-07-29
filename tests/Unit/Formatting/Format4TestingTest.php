<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Format4TestingTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:46
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Formatting;

use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\ToString4Testing;
use Iomywiab\Library\Testing\Formatting\Format4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Format4Testing::class)]
#[UsesClass(Stringable4Testing::class)]
#[UsesClass(ToString4Testing::class)]
class Format4TestingTest extends TestCase
{
    /**
     * @return non-empty-list<non-empty-list<mixed>>
     * @throws \Exception
     */
    public static function provideToStringData(): array
    {
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            \fclose($closedResource);
        }

        return [
            [[], '[]'],
            [[1 => 2, 'a' => 'b'], '[1=>2, "a"=>"b"]'],
            [true, 'true'],
            [false, 'false'],
            [-1.2, '-1.2'],
            [-1.0, '-1.0'],
            [0.0, '0.0'],
            [1.0, '1.0'],
            [1.2, '1.2'],
            [-1, '-1'],
            [0, '0'],
            [1, '1'],
            ['abc', '"abc"'],
            [Enum4Testing::ONE, 'Enum4Testing::ONE'],
            [IntEnum4Testing::ONE, 'IntEnum4Testing::ONE=1'],
            [new Stringable4Testing(), 'stringable'],
            [StringEnum4Testing::ONE, 'StringEnum4Testing::ONE=One'],
            [new ToString4Testing(), 'string'],
            [new \DateTime('2000-01-01 00:00:00', new \DateTimeZone('UTC')), '2000-01-01T00:00:00+00:00'],
            [new \DateTimeZone('UTC'), 'UTC'],
            [new \Exception('error'), 'error'],
            [null, 'null'],
            [$closedResource, 'Unknown'],
        ];
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testOpenResource(): void
    {
        $resource = \fopen('php://memory', 'rb');
        self::assertStringStartsWith('stream (id:', Format4Testing::toString($resource));
    }

    /**
     * @return void
     */
    public function testToClassName(): void
    {
        self::assertSame('stdClass', Format4Testing::toClassName(new \stdClass()));
        self::assertSame('Format4TestingTest', Format4Testing::toClassName($this));
    }

    /**
     * @param mixed $value
     * @param string $expected
     * @return void
     * @throws \JsonException
     * @dataProvider provideToStringData
     */
    public function testToString(mixed $value, string $expected): void
    {
        self::assertSame($expected, Format4Testing::toString($value));
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testToTableString(): void
    {
        $array = [
            [1, 11],
            [22, 2]
        ];
        $expected = "1  11\n22 2 ";
        self::assertSame($expected, Format4Testing::toTableString($array));

        $array = [
            [1, '12345678901234567890123456789012345678901234567890'],
            [22, 2]
        ];
        $expected = "1  \"123456789012345678901234567890123456...\n"
            ."22 2                                       ";
        self::assertSame($expected, Format4Testing::toTableString($array));
    }
}
