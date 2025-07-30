<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableBooleanTestValueTest.php
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
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableBooleanTestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableBooleanTestValueObject::class)]
#[UsesClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class ImmutableBooleanTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testBoolean(): void
    {
        $value = new ImmutableBooleanTestValueObject('test', true);
        self::assertTrue($value->toBool());
        self::assertSame('true', $value->toString());
    }
}
