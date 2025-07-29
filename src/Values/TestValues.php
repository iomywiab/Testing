<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValues.php
 * Project: Testing
 * Modified at: 29/07/2025, 17:06
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class TestValues implements TestValuesInterface
{
    private static ?ImmutableTestValuesInterface $testValues = null;

    /**
     * @inheritDoc
     */
    public static function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->arrays($excludeTags);
    }

    /**
     * @return ImmutableTestValuesInterface
     */
    private static function getTestValues(): ImmutableTestValuesInterface
    {
        if (null === self::$testValues) {
            self::$testValues = new ImmutableTestValues();
        }

        return self::$testValues;
    }

    /**
     * @inheritDoc
     */
    public static function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->booleans($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function empties(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->empties($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function enums(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->enums($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function floats(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->floats($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->get($includeTags, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function getValues(TagsInterface|TagEnum|array|null $includeTags = null, TagsInterface|TagEnum|array|null $excludeTags = null): array
    {
        return self::getTestValues()->getValues($includeTags, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->getWithout($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function integers(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->integers($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->ipAddresses($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->ipv4Addresses($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->ipv6Addresses($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function nulls(): array
    {
        return self::getTestValues()->nulls();
    }

    /**
     * @inheritDoc
     */
    public static function objects(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->objects($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function resources(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->resources($excludeTags);
    }

    /**
     * @inheritDoc
     */
    public static function strings(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return self::getTestValues()->strings($excludeTags);
    }
}
