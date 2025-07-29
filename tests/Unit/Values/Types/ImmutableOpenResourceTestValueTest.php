<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableOpenResourceTestValueTest.php
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
use Iomywiab\Library\Testing\Values\Types\ImmutableOpenResourceTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableOpenResourceTestValue::class)]
#[UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class ImmutableOpenResourceTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testOpenResource(): void
    {
        $openResource = \fopen('php://memory', 'rb');
        $value = new ImmutableOpenResourceTestValue('test', $openResource);
        self::assertSame($openResource, $value->toResource());
        self::assertStringStartsWith('stream (id:', $value->toString());
    }
}
