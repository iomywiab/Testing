<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableIntegerTestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableIntegerTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'integer';

    /**
     * @param non-empty-string|null $description
     * @param int $integer
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, int $integer, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $integer, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toInt(): int
    {
        \assert(\is_int($this->value));

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_int($this->value));

        return (string)$this->value;
    }
}
