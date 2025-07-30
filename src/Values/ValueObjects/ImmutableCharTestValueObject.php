<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableCharTestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableCharTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'char';

    /**
     * @param non-empty-string|null $description
     * @param string $char
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, string $char, ?TagsInterface $tags = null)
    {
        \assert(1 === \mb_strlen($char));

        parent::__construct($description, $char, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_string($this->value));

        return $this->value;
    }
}
