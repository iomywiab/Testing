<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValuesInterface.php
 * Project: Testing
 * Modified at: 29/07/2025, 20:52
 * Modified by: pnehls
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
use Iomywiab\Library\Testing\Values\Types\ImmutableSingleTestValueInterface;

/**
 * Test values and providers for unit tests
 * @psalm-immutable
 */
interface TestValuesInterface
{
    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function empties(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function enums(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function floats(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,ImmutableSingleTestValueInterface>
     * @throws TestValueExceptionInterface
     */
    public static function getValues(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function integers(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function nulls(): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function objects(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function resources(TagsInterface|array|TagEnum|null $excludeTags = null): array;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function strings(TagsInterface|array|TagEnum|null $excludeTags = null): array;
}
