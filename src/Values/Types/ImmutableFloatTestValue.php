<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableFloatTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableFloatTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'float';

    /**
     * @param non-empty-string|null $description
     * @param float $float
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, float $float, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $float, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toFloat(): float
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return (string)$this->value;
    }
}
