<?php /** @noinspection PhpMultipleClassDeclarationsInspection */
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Stringable4Testing.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\DataTypes;

class Stringable4Testing implements \Stringable
{
    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return 'stringable';
    }
}
