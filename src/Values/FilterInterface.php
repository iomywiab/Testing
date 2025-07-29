<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: FilterInterface.php
 * Project: Testing
 * Modified at: 29/07/2025, 15:28
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;

interface FilterInterface
{
    /**
     * @return non-empty-string
     */
    public function getCacheKey(): string;

    /**
     * @param TagEnum|null $tag
     * @return bool
     */
    public function isIncluded(TagEnum|null $tag): bool;
}
