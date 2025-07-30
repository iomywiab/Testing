<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Resources4TestingTest.php
 * Project: Testing
 * Modified at: 30/07/2025, 18:51
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\DataTypes;

use Iomywiab\Library\Testing\DataTypes\Resources4Testing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Resources4Testing::class)]
class Resources4TestingTest extends TestCase
{
    /**
     * @return void
     */
    public static function getClosedMemoryStream(): void
    {
        $handle = Resources4Testing::getClosedMemoryStream();
        self::assertIsResource($handle);
    }

    /**
     * @return void
     */
    public function testGetClosedFile(): void
    {
        $file = Resources4Testing::getClosedFile();
        self::assertIsResource($file);
    }

    /**
     * @return void
     */
    public function testGetOpenFile(): void
    {
        $file = Resources4Testing::getOpenFile();
        self::assertIsResource($file);
        \fclose($file);
    }

    /**
     * @return void
     */
    public function testGetOpenFileForDataProvider(): void
    {
        $file = Resources4Testing::getOpenFileForDataProvider();
        self::assertIsResource($file);
        \fclose($file);
    }

    /**
     * @return void
     */
    public function testGetOpenMemoryStream(): void
    {
        $file = Resources4Testing::getOpenMemoryStream();
        self::assertIsResource($file);
        \fclose($file);
    }
}
