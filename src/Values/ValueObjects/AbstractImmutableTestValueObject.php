<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableTestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueException;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueNotImplementedException;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

abstract class AbstractImmutableTestValueObject implements ImmutableSingleTestValueObjectInterface
{
    /** @var string TYPE_DESCRIPTION to be overloaded */
    protected const TYPE_DESCRIPTION = '';

    private readonly TagsInterface $tags;

    /**
     * @param non-empty-string|null $description
     * @param mixed $value
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(private readonly ?string $description, protected readonly mixed $value, ?TagsInterface $tags = null)
    {
        try {
            // @phpstan-ignore function.alreadyNarrowedType
            \assert(\is_string(static::TYPE_DESCRIPTION) && ('' !== static::TYPE_DESCRIPTION));
            // @phpstan-ignore voku.NotIdentical, notIdentical.alwaysTrue, voku.NotIdentical
            \assert((null === $this->description) || ((null !== $this->description) && ('' !== $this->description)));
            // @phpstan-ignore voku.NotIdentical, notIdentical.alwaysTrue
            \assert((null === $tags) || ((null !== $tags) && !$tags->isEmpty()));

            $this->tags = Tags::fromData($value)
                ->add($tags)
                ->add(TagEnum::ARRAY)
                ->add(TagEnum::STRING);
        } catch (\Throwable $cause) {
            throw new TestValueException('Unable to construct test value', $cause);
        }
    }

    /**
     * @inheritDoc
     * @throws TestValueExceptionInterface
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @inheritDoc
     */
    public function getTags(): TagsInterface
    {
        return $this->tags;
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        $description = (null === $this->description) ? '' : '('.$this->description.')';

        return static::TYPE_DESCRIPTION.$description.': '.$this->toString();
    }

    /**
     * @inheritDoc
     */
    final public function getValueByTag(TagEnum $tag): mixed
    {
        /** @noinspection PhpDuplicateMatchArmBodyInspection */
        return match ($tag) {
            TagEnum::ARRAY => $this->toArray(),
            TagEnum::BOOLEAN => $this->toBool(),
            TagEnum::BOOL_STRING => $this->toString(),
            TagEnum::CAPITAL_LETTER => $this->toString(),
            TagEnum::CHAR => $this->toString(),
            TagEnum::CLOSED_RESOURCE => $this->toRawValue(),
            TagEnum::DATETIME => $this->toObject(),
            TagEnum::DIGIT => $this->toString(),
            TagEnum::DOMAIN => $this->toString(),
            TagEnum::EMAIL => $this->toString(),
            TagEnum::EMPTY => $this->toRawValue(),
            TagEnum::ENUM => $this->toObject(),
            TagEnum::ENUM_INT => $this->toObject(),
            TagEnum::ENUM_STRING => $this->toObject(),
            TagEnum::EXCEPTION => $this->toObject(),
            TagEnum::FLOAT => $this->toFloat(),
            TagEnum::FLOAT_NEGATIVE => $this->toFloat(),
            TagEnum::FLOAT_NOT_NEGATIVE => $this->toFloat(),
            TagEnum::FLOAT_POSITIVE => $this->toFloat(),
            TagEnum::FLOAT_WITH_INT_VALUE => $this->toFloat(),
            TagEnum::INTEGER => $this->toInt(),
            TagEnum::INTEGER_NEGATIVE => $this->toInt(),
            TagEnum::INTEGER_NOT_NEGATIVE => $this->toInt(),
            TagEnum::INTEGER_POSITIVE => $this->toInt(),
            TagEnum::IP_ADDRESS => \is_int($this->value) ? $this->toInt() : $this->toString(),
            TagEnum::IPv4 => \is_int($this->value) ? $this->toInt() : $this->toString(),
            TagEnum::IPv6 => \is_int($this->value) ? $this->toInt() : $this->toString(),
            TagEnum::LETTER => $this->toString(),
            TagEnum::MAC => $this->toString(),
            TagEnum::NULL => $this->toRawValue(),
            TagEnum::OBJECT => $this->toObject(),
            TagEnum::PRIME => \is_int($this->value) ? $this->toInt() : $this->toString(),
            TagEnum::RESOURCE => $this->toResource(),
            TagEnum::SMALL_LETTER => $this->toString(),
            TagEnum::STRING => $this->toString(),
            TagEnum::STRING_FLOAT => $this->toString(),
            TagEnum::STRING_INTEGER => $this->toString(),
            TagEnum::STRING_LOWER => $this->toString(),
            TagEnum::STRING_NUMERIC => $this->toString(),
            TagEnum::STRING_UPPER => $this->toString(),
            TagEnum::URL => $this->toString(),
        };
    }

    /**
     * @inheritDoc
     */
    // @phpstan-ignore shipmonk.returnListNotUsed
    public function toArray(): array
    {
        return [$this->value];
    }

    /**
     * @inheritDoc
     */
    public function toBool(): bool
    {
        throw new TestValueNotImplementedException(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function toRawValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toObject(): object
    {
        throw new TestValueNotImplementedException(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function toFloat(): float
    {
        throw new TestValueNotImplementedException(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function toInt(): int
    {
        throw new TestValueNotImplementedException(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function toResource(): mixed
    {
        throw new TestValueNotImplementedException(__METHOD__);
    }
}
