<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableClosedResourceTestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableClosedResourceTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'closed resource';

    /**
     * @param non-empty-string|null $description
     * @param mixed $resource
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, mixed $resource, ?TagsInterface $tags = null)
    {
        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::CLOSED_RESOURCE);

        parent::__construct($description, $resource, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toResource(): mixed
    {
        // @phpstan-ignore return.type
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        // @phpstan-ignore greaterOrEqual.alwaysTrue
        $id = (PHP_VERSION_ID >= 80000)
            // @phpstan-ignore argument.type
            ? ' (id:'.\get_resource_id($this->value).')'
            : '';

        // @phpstan-ignore argument.type
        return \get_resource_type($this->value).$id;
    }
}
