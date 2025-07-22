<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TagsInterface.php
 * Project: Testing
 * Modified at: 21/07/2025, 11:20
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Tags;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;

interface TagsInterface extends \Stringable
{
    /**
     * @return int
     */
    public function getBitmask(): int;

    /**
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $tag
     * @return self
     */
    public function add(TagsInterface|TagEnum|array|null $tag): self;

    /**
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $tag
     * @return self
     */
    public function remove(TagsInterface|TagEnum|array|null $tag): self;

    /**
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $tag
     * @return bool
     */
    public function contains(TagsInterface|TagEnum|array|null $tag): bool;

    /**
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $tag
     * @return bool
     */
    public function intersects(TagsInterface|TagEnum|array|null $tag): bool;

    /**
     * @return bool
     */
    public function isEmpty():bool;

    /**
     * @return list<TagEnum>
     */
    public function  cases(): array;

    /**
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $includeTags
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $excludeTags
     * @return TagsInterface
     */
    public function getFiltered(TagsInterface|TagEnum|array|null $includeTags = null, TagsInterface|TagEnum|array|null $excludeTags = null): TagsInterface;

    /**
     * @return TagsInterface
     */
    public function getInverse(): TagsInterface;
}
