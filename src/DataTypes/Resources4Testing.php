<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Resources4Testing.php
 * Project: Testing
 * Modified at: 30/07/2025, 18:51
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\DataTypes;

use Iomywiab\Library\Testing\TestConfig;

class Resources4Testing
{
    /**
     * @return closed-resource|false
     */
    public static function getClosedFile(): mixed
    {
        $file = self::getOpenFile();
        if (false !== $file) {
            \fclose($file);
        }

        return $file;
    }

    /**
     * @return resource|false
     */
    public static function getOpenFile(): mixed
    {
        return \tmpfile();
    }

    /**
     * @return closed-resource|false
     */
    public static function getClosedMemoryStream(): mixed
    {
        $handle = self::getOpenMemoryStream();
        if (false !== $handle) {
            \fclose($handle);
        }

        return $handle;
    }

    /**
     * @return resource|false
     */
    public static function getOpenMemoryStream(): mixed
    {
        return \fopen('php://memory', 'rb');
    }

    /**
     * @return resource|false
     */
    public static function getOpenFileForDataProvider(): mixed
    {
        return \fopen(TestConfig::TEST_VALUES_FILE, 'rb');
    }
}
