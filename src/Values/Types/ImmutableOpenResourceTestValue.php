<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableOpenResourceTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableOpenResourceTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'open resource';

    /**
     * @param non-empty-string|null $description
     * @param mixed $resource
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, mixed $resource, ?TagsInterface $tags = null)
    {
        \assert(\is_resource($resource));

        parent::__construct($description, $resource, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toResource(): mixed
    {
        \assert(\is_resource($this->value));

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_resource($this->value));

        // @phpstan-ignore greaterOrEqual.alwaysTrue
        $id = (PHP_VERSION_ID >= 80000)
            ? ' (id:'.\get_resource_id($this->value).')'
            : '';

        return \get_resource_type($this->value).$id;
    }
}
