<?php /*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Stringable4Testing.php
 * Project: Testing
 * Modified at: 29/07/2025, 21:08
 * Modified by: pnehls
 */
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace Iomywiab\Library\Testing\DataTypes;

class Stringable4Testing implements \Stringable
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(private readonly string $value = 'stringable')
    {
        // no code
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
