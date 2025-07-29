<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ToString4TestingTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:52
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\DataTypes;

use Iomywiab\Library\Testing\DataTypes\ToString4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ToString4Testing::class)]
class ToString4TestingTest extends TestCase
{
    /**
     * @return void
     */
    public function testStringable4Testing(): void
    {
        self::assertSame('string', (new ToString4Testing())->toString());
        self::assertSame('test', (new ToString4Testing('test'))->toString());
    }
}
