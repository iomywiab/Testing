<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Tags.php
 * Project: Testing
 * Modified at: 21/07/2025, 11:44
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Tags;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueException;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;

class Tags implements TagsInterface
{
    private const EMPTY_BITMASK = 0;
    private const DEFAULT_BITMASK = self::EMPTY_BITMASK;
    private int $bitmask;

    /**
     * @param int|TagEnum|TagsInterface|list<TagEnum>|null $bitmask
     */
    public function __construct(int|TagEnum|TagsInterface|array|null $bitmask = null)
    {
        if ((null === $bitmask) || ([] === $bitmask)) {
            $this->bitmask = self::DEFAULT_BITMASK;

            return;
        }

        if (\is_int($bitmask)) {
            $this->bitmask = $bitmask;

            return;
        }

        if ($bitmask instanceof TagEnum) {
            $this->bitmask = $bitmask->value;

            return;
        }

        if ($bitmask instanceof TagsInterface) {
            $this->bitmask = $bitmask->getBitmask();

            return;
        }

        \assert(\is_array($bitmask));

        $this->bitmask = self::EMPTY_BITMASK;
        foreach ($bitmask as $item) {
            $this->bitmask |= $item->value;
        }
    }

    /**
     * @inheritDoc
     */
    public function getBitmask(): int
    {
        return $this->bitmask;
    }

    /**
     * @inheritDoc
     */
    public function add(TagsInterface|TagEnum|array|null $tag): self
    {
        if (null === $tag) {
            return $this;
        }

        $newTags = new self($tag);
        $this->bitmask |= $newTags->bitmask;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove(TagsInterface|TagEnum|array|null $tag): self
    {
        if (null === $tag) {
            return $this;
        }

        $newTags = new self($tag);
        $this->bitmask &= ~$newTags->bitmask;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function contains(TagsInterface|TagEnum|array|null $tag): bool
    {
        if (null === $tag) {
            return false;
        }

        $newTags = new self($tag);
        $value = $newTags->bitmask;

        return $value === ($this->bitmask & $value);
    }

    /**
     * @inheritDoc
     */
    public function intersects(TagsInterface|TagEnum|array|null $tag): bool {
        if (null === $tag) {
            return false;
        }

        $newTags = new self($tag);
        $value = $newTags->bitmask;

        return 0 !== ($this->bitmask & $value);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return self::EMPTY_BITMASK === $this->bitmask;
    }

    /**
     * @inheritDoc
     */
    public function cases(): array
    {
        $array = [];
        foreach (TagEnum::cases() as $case) {
            if ($this->contains($case)) {
                $array[$case->name] = $case;
            }
        }
        \ksort($array);

        return \array_values($array);
    }

    /**
     * @inheritDoc
     */
    public function getFiltered(TagsInterface|TagEnum|array|null $includeTags = null, TagsInterface|TagEnum|array|null $excludeTags = null): TagsInterface
    {
        $includeTags = new Tags($includeTags);
        $excludeTags = new Tags($excludeTags);

        $bitmask = $this->bitmask;

        if (!$includeTags->isEmpty()) {
            $bitmask &= $includeTags->getBitmask();
        }
        if (!$excludeTags->isEmpty()) {
            $bitmask &= ~$excludeTags->getBitmask();
        }

        return new self($bitmask);
    }

    /**
     * @inheritDoc
     */
    public function getInverse(): TagsInterface
    {
        return new self(~$this->bitmask);
    }

    /**
     * @param mixed $value
     * @return self
     * @throws TestValueExceptionInterface
     */
    public static function fromData(mixed $value): self
    {
        try {
            $tags = new Tags();
            foreach (TagEnum::cases() as $case) {
                if ($case->isMine($value)){
                    $tags->add($case);
                }
            }
            return $tags;
        } catch (\Throwable $cause) {
            throw new TestValueException('Unable to get tags from data', $cause);
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $string = '';
        $sep = '';
        foreach ($this->cases() as $case) {
            $string .= $sep.$case->name;
            $sep = ',';
        }
        return $string;
    }
}
