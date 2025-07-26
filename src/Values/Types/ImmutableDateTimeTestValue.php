<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableDateTimeTestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types = 1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueException;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableDateTimeTestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'dateTime';

    /**
     * @param non-empty-string|null $description
     * @param non-empty-string|\DateTimeInterface $dateTime
     * @param TagsInterface|null $tags
     */
    public function __construct(?string $description, string|\DateTimeInterface $dateTime, ?TagsInterface $tags=null)
    {
        try {
            // @phpstan-ignore voku.NotIdentical
            \assert((\is_string($dateTime) && ('' !== $dateTime)) || ($dateTime instanceof \DateTimeInterface));

            $dateTime = \is_string($dateTime)
                ? new \DateTimeImmutable($dateTime, new \DateTimeZone('UTC'))
                : $dateTime;

            // @phpstan-ignore voku.Coalesce
            $tags ??= new Tags();
            $tags->add(TagEnum::DATETIME);

            parent::__construct($description, $dateTime, $tags);
        } catch (\Throwable $cause) {
            throw new TestValueException('Unable to construct date time test value', $cause);
        }
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert($this->value instanceof \DateTimeInterface);

        return $this->value->format(\DateTimeInterface::ATOM);
    }

    /**
     * @inheritDoc
     */
    public function toInt(): int
    {
        \assert($this->value instanceof \DateTimeInterface);

        return $this->value->getTimestamp();
    }

    /**
     * @inheritDoc
     */
    public function toObject(): object
    {
        \assert($this->value instanceof \DateTimeInterface);

        return $this->value;
    }
}
