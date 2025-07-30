<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutablePrimeTestValue.php
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

class ImmutablePrimeTestValue extends ImmutableIntegerTestValueObject
{
    protected const TYPE_DESCRIPTION = 'prime';

    /**
     * @param non-empty-string|null $description
     * @param int $integer
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, int $integer, ?TagsInterface $tags = null)
    {
        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::PRIME);

        parent::__construct($description, $integer, $tags);
    }
}
