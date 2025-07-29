<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Stringable4TestingTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:52
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\DataTypes;

use Iomywiab\Library\Testing\DataTypes\Stringable4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Stringable4Testing::class)]
class Stringable4TestingTest extends TestCase
{
    /**
     * @return void
     */
    public function testStringable4Testing(): void
    {
        self::assertSame('stringable', (string)(new Stringable4Testing()));
        self::assertSame('test', (string)(new Stringable4Testing('test')));
    }
}
