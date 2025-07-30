<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableIpv4TestValueObject.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\ValueObjects;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueException;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableIpv4TestValueObject extends AbstractImmutableTestValueObject
{
    protected const TYPE_DESCRIPTION = 'IPv4';

    /**
     * @param non-empty-string|null $description
     * @param string $ipv4
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, string $ipv4, ?TagsInterface $tags = null)
    {
        \assert(filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4), $ipv4);

        // @phpstan-ignore voku.Coalesce
        $tags ??= new Tags();
        $tags->add(TagEnum::INTEGER);
        $tags->add(TagEnum::IPv4);
        $tags->add(TagEnum::IP_ADDRESS);

        parent::__construct($description, $ipv4, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toInt(): int
    {
        \assert(\is_string($this->value));
        $result = \ip2long($this->value);

        if (false === $result) {
            throw new TestValueException('Unable to convert IPv4 to integer. ipv4="'.$this->value.'"');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        \assert(\is_string($this->value));

        return $this->value;
    }
}
