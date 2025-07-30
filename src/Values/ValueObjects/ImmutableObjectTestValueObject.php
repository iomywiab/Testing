<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableObjectTestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableObjectTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'object';

    /**
     * @param non-empty-string|null $description
     * @param object $object
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, object $object, ?TagsInterface $tags = null)
    {
        parent::__construct($description, $object, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toObject(): object
    {
        \assert(\is_object($this->value));

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_object($this->value));

        /** @noinspection PhpMultipleClassDeclarationsInspection */
        // @phpstan-ignore return.type
        return match (true) {
            $this->value instanceof \Stringable => (string)$this->value,
            \method_exists($this->value, 'toString') => $this->value->toString(),
            default => \serialize($this->value),
        };
    }
}
