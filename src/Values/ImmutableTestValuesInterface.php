<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValuesInterface.php
 * Project: Testing
 * Modified at: 30/07/2025, 00:08
 * Modified by: pnehls
 */

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableSingleTestValueObjectInterface;

/**
 * Test values and providers for unit tests
 * @psalm-immutable
 */
interface ImmutableTestValuesInterface
{
    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,array<array-key,mixed>>
     * @throws TestValueExceptionInterface
     */
    public function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,bool>
     * @throws TestValueExceptionInterface
     */
    public function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public function empties(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,\UnitEnum>
     * @throws TestValueExceptionInterface
     */
    public function enums(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,float>
     * @throws TestValueExceptionInterface
     */
    public function floats(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     */
    public function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,ImmutableSingleTestValueObjectInterface>
     */
    public function getValueObjects(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,int>
     * @throws TestValueExceptionInterface
     */
    public function integers(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     * @throws TestValueExceptionInterface
     */
    public function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     * @throws TestValueExceptionInterface
     */
    public function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,non-empty-string>
     * @throws TestValueExceptionInterface
     */
    public function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @return \Generator<non-empty-string,null>
     * @throws TestValueExceptionInterface
     */
    public function nulls(): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,object>
     * @throws TestValueExceptionInterface
     */
    public function objects(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,resource>
     * @throws TestValueExceptionInterface
     */
    public function resources(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;

    /**
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,string>
     * @throws TestValueExceptionInterface
     */
    public function strings(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator;
}
