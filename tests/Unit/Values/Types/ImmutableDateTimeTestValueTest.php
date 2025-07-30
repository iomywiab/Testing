<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableDateTimeTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\DataTypes\DateTime4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\ValueObjects\AbstractImmutableTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableDateTimeTestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableDateTimeTestValueObject::class)]
#[UsesClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
#[UsesClass(DateTime4Testing::class)]
class ImmutableDateTimeTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testDateTime(): void
    {
        $value = new ImmutableDateTimeTestValueObject('test', DateTime4Testing::STRING_VALUE);
        self::assertSame(DateTime4Testing::INT_VALUE, $value->toInt());
        self::assertSame(DateTime4Testing::STRING_VALUE, $value->toString());
        self::assertInstanceOf(\DateTimeInterface::class, $value->toObject());

        $dt = new DateTime4Testing();
        $value = new ImmutableDateTimeTestValueObject('test', $dt);
        self::assertSame(DateTime4Testing::INT_VALUE, $value->toInt());
        self::assertSame(DateTime4Testing::STRING_VALUE, $value->toString());
        self::assertSame($dt, $value->toObject());
    }
}
