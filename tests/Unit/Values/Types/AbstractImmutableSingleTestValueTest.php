<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableSingleTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:22
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueNotImplementedException;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableArrayTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableArrayTestValue::class)]
#[UsesClass(TestValueExceptionInterface::class), UsesClass(TestValueNotImplementedException::class), UsesClass(TagEnum::class), UsesClass(Tags::class), UsesClass(AbstractImmutableSingleTestValue::class)]
class AbstractImmutableSingleTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToBool(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toBool();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToFloat(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toFloat();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToInt(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toInt();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToObject(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toObject();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToResource(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toResource();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testStringable(): void
    {
        self::assertSame('[0=>testValue]', (string) new ImmutableArrayTestValue('testDescription', ['testValue']));
    }
}
