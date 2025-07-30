<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValuesInterface.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:44
 * Modified by: pnehls
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableSingleTestValueObjectInterface;

/**
 * Test values and providers for unit tests
 * @psalm-immutable
 */
interface TestValuesInterface
{
    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,array<array-key,mixed>>
     */
    public static function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,bool>
     */
    public static function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     */
    public static function empties(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,\UnitEnum>
     */
    public static function enums(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,float>
     */
    public static function floats(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     */
    public static function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,ImmutableSingleTestValueObjectInterface>
     */
    public static function getValueObjects(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     */
    public static function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,int>
     */
    public static function integers(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     */
    public static function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     */
    public static function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     */
    public static function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @return \Generator<non-empty-string,null>
     */
    public static function nulls(): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,object>
     */
    public static function objects(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,resource>
     */
    public static function resources(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,string>
     */
    public static function strings(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;
}
