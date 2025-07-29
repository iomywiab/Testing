<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ToString4Testing.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:51
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\DataTypes;

class ToString4Testing
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(private readonly string $value = 'string')
    {
        // no code
    }

    /**
     * @return non-empty-string
     */
    public function toString(): string
    {
        return $this->value;
    }
}
