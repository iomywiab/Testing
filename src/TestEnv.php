<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestEnv.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing;

class TestEnv
{
    /**
     * Workaround to check for process isolation in PHPUnit (as there is no API provided by PHPUnit)
     * Attention! Does not work on the first call!!!
     */
    public static function runsInProcessIsolation(): bool
    {
        /** @var non-negative-int $count */
        static $count = 0;
        $count++;

        return 1 === $count;
    }
}
