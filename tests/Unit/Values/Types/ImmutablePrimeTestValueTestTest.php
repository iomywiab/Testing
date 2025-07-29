<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutablePrimeTestValueTestTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 18:32
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableIntegerTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutablePrimeTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutablePrimeTestValue::class)]
#[UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
#[UsesClass(ImmutableIntegerTestValue::class)]
class ImmutablePrimeTestValueTestTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testPrime(): void
    {
        $value = new ImmutablePrimeTestValue('test', 7);
        self::assertSame(7, $value->toInt());
        self::assertSame('7', $value->toString());
    }
}
