<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableArrayTestValue.php
 * Project: Testing
 * Modified at: 29/07/2025, 17:50
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableArrayTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'array';

    /**
     * @param non-empty-string|null $description
     * @param array<array-key,mixed> $array
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, array $array, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $array, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        \assert(\is_array($this->value));

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_array($this->value));

        $string = '[';
        $separator = '';
        foreach ($this->value as $key => $value) {
            $string .= $separator.$key.'=>'.(\is_scalar($value) ? (string)$value : \gettype($value));
            $separator = ',';
        }

        return $string.']';
    }
}
