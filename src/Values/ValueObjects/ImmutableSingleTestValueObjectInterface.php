<?php /*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableSingleTestValueObjectInterface.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:52
 * Modified by: pnehls
 */
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

interface ImmutableSingleTestValueObjectInterface extends \Stringable
{
    /**
     * @return TagsInterface
     */
    public function getTags(): TagsInterface;

    /**
     * @return non-empty-string
     * @throws TestValueExceptionInterface
     */
    public function getTitle(): string;

    /**
     * @param TagEnum $tag
     * @return mixed
     * @throws TestValueExceptionInterface
     */
    public function getValueByTag(TagEnum $tag): mixed;

    /**
     * @return array<array-key,mixed>
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
     * @return mixed
     * @throws TestValueExceptionInterface
     */
    public function toRawValue(): mixed;

    /**
     * @return resource
     * @throws TestValueExceptionInterface
     */
    public function toResource(): mixed;

    /**
     * @return string
     * @throws TestValueExceptionInterface
     */
    public function toString(): string;
}
