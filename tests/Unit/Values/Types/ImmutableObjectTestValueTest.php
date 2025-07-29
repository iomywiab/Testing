<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableObjectTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 20:52
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use Iomywiab\Library\Testing\DataTypes\ToString4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableObjectTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableObjectTestValue::class)]
#[UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
#[UsesClass(Stringable4Testing::class)]
#[UsesClass(ToString4Testing::class)]
class ImmutableObjectTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testObjects(): void
    {
        $obj1 = new Stringable4Testing();
        $value = new ImmutableObjectTestValue('test', $obj1);
        self::assertSame($obj1, $value->toObject());
        self::assertSame('stringable', $value->toString());

        $obj2 = new ToString4Testing();
        $value = new ImmutableObjectTestValue('test', $obj2);
        self::assertSame($obj2, $value->toObject());
        self::assertSame('string', $value->toString());
    }
}
