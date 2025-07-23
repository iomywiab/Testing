<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValues.php
 * Project: Testing
 * Modified at: 23/07/2025, 21:11
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableTestValues extends AbstractImmutableTestValues
{
    /** @var array<non-empty-string,array<non-empty-string,mixed>> $cache */
    private static array $cache = [];

    /**
     * @inheritDoc
     */
    public static function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get(TagEnum::ARRAY, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        $includeTags = new Tags($includeTags);
        $excludeTags = new Tags($excludeTags);
        $key = self::getCacheKey($includeTags, $excludeTags);

        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $values = [];
        $allValues = self::getValues();
        foreach ($allValues as $value) {
            $tags = $value->getTags();
            if (!$tags->intersects($excludeTags)) {
                foreach ($tags->cases() as $tag) {
                    $included = $includeTags->isEmpty() || $includeTags->contains($tag);
                    if ($included) {
                        $val = $value->getValueByTag($tag);
                        $name = \mb_strtolower($tag->name);
                        $title = $value->getTitle();
                        $key = ($name === $title) ? $name : $name.' of '.$title;
                        \assert(!\array_key_exists($key, $values), '['.$key.'] already exists');
                        $values[$key] = $val;
                    }
                }
            }
        }

        self::$cache[$key] = $values;

        return $values;
    }

    /**
     * @param TagsInterface $includeTags
     * @param TagsInterface $excludeTags
     * @return non-empty-string
     */
    private static function getCacheKey(TagsInterface $includeTags, TagsInterface $excludeTags): string
    {
        $includeKey = $includeTags->getBitmask();
        $excludeKey = $excludeTags->getBitmask();

        return $includeKey.'-'.$excludeKey;
    }

    /**
     * @inheritDoc
     */
    public static function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::BOOLEAN], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function empties(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::EMPTY], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function enums(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::ENUM], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function floats(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::FLOAT], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get(null, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function integers(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::INTEGER], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::IP_ADDRESS], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::IPv4], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::IPv6], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function nulls(): array
    {
        return self::get([TagEnum::NULL]);
    }

    /**
     * @inheritDoc
     */
    public static function objects(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::OBJECT], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function resources(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::RESOURCE], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function strings(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::get([TagEnum::STRING], $excludeTags);
    }

}
