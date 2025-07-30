<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DataProviderTest.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:47
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values;

use Iomywiab\Library\Testing\Values\DataProvider;
use Iomywiab\Library\Testing\Values\Enums\SubstitutionEnum;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Filter;
use Iomywiab\Library\Testing\Values\ImmutableTestValues;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\TestValues;
use Iomywiab\Library\Testing\Values\ValueObjects\AbstractImmutableTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableIntegerTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableNullTestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DataProvider::class)]
#[UsesClass(SubstitutionEnum::class)]
#[UsesClass(TestValues::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(TestValueExceptionInterface::class)]
#[UsesClass(ImmutableTestValues::class)]
#[UsesClass(Tags::class)]
#[UsesClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(ImmutableIntegerTestValueObject::class)]
#[UsesClass(ImmutableNullTestValueObject::class)]
#[UsesClass(Filter::class)]
class DataProviderTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testByTemplate(): void
    {
        $values = DataProvider::byTemplate(
            ['one' => true, 'two' => SubstitutionEnum::KEY, 'three' => SubstitutionEnum::VALUE, 'four' => 'test'],
            TagEnum::NULL
        );
        $expected = [
            'null' => ['one' => true, 'two' => 'null', 'three' => null, 'four' => 'test'],
        ];
        self::assertEquals($expected, \iterator_to_array($values, true));

        $values = DataProvider::byTemplate(['one' => true, 'two' => 1, 'three' => SubstitutionEnum::VALUE, 'four' => 'test'], TagEnum::PRIME);
        $expected = [
            'prime of prime(smallest signed 1 byte prime number): -127' => ['one' => true, 'two' => 1, 'three' => -127, 'four' => 'test'],
            'prime of prime(negative prime number): -7'                 => ['one' => true, 'two' => 1, 'three' => -7, 'four' => 'test'],
            'prime of prime(greatest even negative prime number): -2'   => ['one' => true, 'two' => 1, 'three' => -2, 'four' => 'test'],
            'prime of prime(smallest even positive prime number): 2'    => ['one' => true, 'two' => 1, 'three' => 2, 'four' => 'test'],
            'prime of prime(positive prime number): 7'                  => ['one' => true, 'two' => 1, 'three' => 7, 'four' => 'test'],
            'prime of prime(signed 4 byte prime number): 2147483647'    => ['one' => true, 'two' => 1, 'three' => 2147483647, 'four' => 'test'],
        ];

        self::assertEquals($expected, \iterator_to_array($values, true));
    }

    public function testInjectKeys(): void
    {
        $values = DataProvider::injectKeys(['one', 'two', '11', '22'], ['a' => [1, 2, 3, 4], 'b' => [5, 6, 7, 8]]);
        self::assertEquals([
            'a' => ['one' => 1, 'two' => 2, 11 => 3, 22 => 4],
            'b' => ['one' => 5, 'two' => 6, 11 => 7, 22 => 8]
        ], iterator_to_array($values, true));
    }
}
