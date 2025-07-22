<?php /** @noinspection PhpMultipleClassDeclarationsInspection */
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableSingleTestValueInterface.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

interface ImmutableSingleTestValueInterface extends \Stringable
{
    /**
     * @return non-empty-string
     * @throws TestValueExceptionInterface
     */
    public function getTitle(): string;

    /**
     * @return TagsInterface
     */
    public function getTags(): TagsInterface;

    /**
     * @param TagEnum $tag
     * @return mixed
     * @throws TestValueExceptionInterface
     */
    public function getValueByTag(TagEnum $tag): mixed;

    /**
     * @return array
     * @throws TestValueExceptionInterface
     */
    public function toArray(): array;

    /**
     * @return bool
     * @throws TestValueExceptionInterface
     */
    public function toBool(): bool;

    /**
     * @return float
     * @throws TestValueExceptionInterface
     */
    public function toFloat(): float;

    /**
     * @return int
     * @throws TestValueExceptionInterface
     */
    public function toInt(): int;

    /**
     * @return object
     * @throws TestValueExceptionInterface
     */
    public function toObject(): object;

    /**
     * @return resource
     * @throws TestValueExceptionInterface
     */
    public function toResource(): mixed;

    /**
     * @return mixed
     * @throws TestValueExceptionInterface
     */
    public function toRawValue(): mixed;

    /**
     * @return string
     * @throws TestValueExceptionInterface
     */
    public function toString(): string;
}
