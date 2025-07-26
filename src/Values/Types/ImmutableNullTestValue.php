<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableNullTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableNullTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'null';

    /**
     * @param non-empty-string|null $description
     * @param mixed $null
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, mixed $null, ?TagsInterface $tags = null)
    {
        \assert(\is_null($null));

        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::NULL);

        parent::__construct($description, $null, $tags);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'null';
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'null';
    }
}
