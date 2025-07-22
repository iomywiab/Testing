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

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableExceptionTestValue extends AbstractImmutableSingleTestValue
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
        $tags??=new Tags();
        $tags->add(TagEnum::EXCEPTION);

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
        return $this->value->getMessage();
    }
}
