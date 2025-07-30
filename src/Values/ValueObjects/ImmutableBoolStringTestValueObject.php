<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableBoolStringTestValueObject.php
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

class ImmutableBoolStringTestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'boolString';

    /**
     * @param non-empty-string|null $description
     * @param string $value
     * @param bool $boolValue
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, string $value, private readonly bool $boolValue, ?TagsInterface $tags = null)
    {
        \assert('' !== $value);

        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::BOOLEAN);
        $tags->add(TagEnum::BOOL_STRING);

        parent::__construct($description, $value, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toBool(): bool
    {
        return $this->boolValue;
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
