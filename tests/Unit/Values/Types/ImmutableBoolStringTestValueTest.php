<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableBoolStringTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 20:52
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableBoolStringTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableBoolStringTestValue::class)]
#[UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class ImmutableBoolStringTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testBooleanString(): void
    {
        $value = new ImmutableBoolStringTestValue('test', 'xxx', true);
        self::assertTrue($value->toBool());
        self::assertSame('xxx', $value->toString());
    }
}
