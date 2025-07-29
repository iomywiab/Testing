<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AllExceptionsTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:57
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Exceptions;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueException;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueNotImplementedException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TestValueException::class)]
#[CoversClass(TestValueNotImplementedException::class)]
class AllExceptionsTest extends TestCase
{
    /**
     * @return void
     */
    public function testAllExceptions(): void
    {
        self::assertSame('testMessage', (new TestValueException('testMessage'))->getMessage());
        self::assertSame('Not implemented. method="testMethodName"', (new TestValueNotImplementedException('testMethodName'))->getMessage());
    }
}
