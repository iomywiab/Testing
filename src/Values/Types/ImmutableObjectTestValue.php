<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableObjectTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableObjectTestValue extends AbstractImmutableSingleTestValue
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
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        /** @noinspection PhpMultipleClassDeclarationsInspection */
        return match (true) {
            $this->value instanceof \Stringable => (string)$this->value,
            \method_exists($this->value, 'toString') => $this->value->toString(),
            default=>\serialize($this->value),
        };
    }
}
