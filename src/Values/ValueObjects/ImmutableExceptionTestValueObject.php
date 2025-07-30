<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableExceptionTestValueObject.php
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

class ImmutableExceptionTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'exception';

    /**
     * @param non-empty-string|null $description
     * @param \Throwable $object
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, \Throwable $object, ?TagsInterface $tags = null)
    {
        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::EXCEPTION);

        parent::__construct($description, $object, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toObject(): object
    {
        \assert($this->value instanceof \Throwable);

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert($this->value instanceof \Throwable);

        return $this->value->getMessage();
    }
}
