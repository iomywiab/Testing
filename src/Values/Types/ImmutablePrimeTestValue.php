<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutablePrimeTestValue.php
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

class ImmutablePrimeTestValue extends ImmutableIntegerTestValue
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
        $tags ??= new Tags();
        $tags->add(TagEnum::PRIME);

        parent::__construct($description, $integer, $tags);
    }
}
