<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DateTime4Testing.php
 * Project: Testing
 * Modified at: 29/07/2025, 18:03
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\DataTypes;

class DateTime4Testing extends \DateTime
{
    public const INT_VALUE = 0;
    public const STRING_VALUE = '1970-01-01T00:00:00+00:00';

    public function __construct()
    {
        $tz = new \DateTimeZone('UTC');
        parent::__construct('1970-01-01 00:00:00', $tz);
    }
}
