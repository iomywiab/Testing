<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 18:34
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableFloatTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableFloatTestValue::class)]
#[UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class ImmutableFloatTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testFloat(): void
    {
        $value = new ImmutableFloatTestValue('test', 1.2);
        self::assertSame(1.2, $value->toFloat());
        self::assertSame('1.2', $value->toString());
    }
}
