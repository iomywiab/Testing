<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Filter.php
 * Project: Testing
 * Modified at: 29/07/2025, 21:08
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class Filter implements FilterInterface
{
    private readonly TagsInterface $excludeTags;
    private readonly TagsInterface $includeTags;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     */
    public function __construct(
        TagsInterface|array|TagEnum|null $includeTags = null,
        TagsInterface|array|TagEnum|null $excludeTags = null
    ) {
        $this->includeTags = new Tags($includeTags);
        $this->excludeTags = new Tags($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function getCacheKey(): string
    {
        $includeKey = $this->includeTags->getBitmask();
        $excludeKey = $this->excludeTags->getBitmask();

        return $includeKey.'-'.$excludeKey;
    }

    /**
     * @inheritDoc
     */
    public function isIncluded(TagEnum|null $tag): bool
    {
        $included = ($this->includeTags->isEmpty() || $this->includeTags->contains($tag));
        $excluded = ($this->excludeTags->contains($tag));

        return ($included && !$excluded);
    }
}
