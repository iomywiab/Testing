<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableStringTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableStringTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'string';

    /**
     * @param non-empty-string|null $description
     * @param string $string
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, string $string, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $string, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_string($this->value), 'Value is not a string: ' . \gettype($this->value));
        return $this->value;
    }
}
