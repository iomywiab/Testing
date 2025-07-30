<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableIpv4TestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\ValueObjects\AbstractImmutableTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableIpv4TestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableIpv4TestValueObject::class)]
#[UsesClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class ImmutableIpv4TestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testIpv4(): void
    {
        $value = new ImmutableIpv4TestValueObject('test', '127.0.0.1');
        self::assertSame(2130706433, $value->toInt());
        self::assertSame('127.0.0.1', $value->toString());
    }

}
