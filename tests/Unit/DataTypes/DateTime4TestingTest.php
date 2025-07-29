<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DateTime4TestingTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 19:12
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\DataTypes;

use Iomywiab\Library\Testing\DataTypes\DateTime4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateTime4Testing::class)]
class DateTime4TestingTest extends TestCase
{
    /**
     * @return void
     */
    public function testDateTime(): void
    {
        $dt = new DateTime4Testing();
        self::assertSame(DateTime4Testing::STRING_VALUE, $dt->format(\DateTimeInterface::ATOM));
        self::assertSame(DateTime4Testing::INT_VALUE, $dt->getTimestamp());
    }
}
