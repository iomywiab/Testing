<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableBooleanTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableBooleanTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'boolean';

    /**
     * @param non-empty-string|null $description
     * @param bool $value
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, bool $value, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $value, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toBool(): bool
    {
        \assert(\is_bool($this->value));

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_bool($this->value));

        return $this->value ? 'true' : 'false';
    }
}
