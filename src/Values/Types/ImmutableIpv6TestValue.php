<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableIpv4TestValue.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Types;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class ImmutableIpv6TestValue extends AbstractImmutableSingleTestValue
{
    protected const TYPE_DESCRIPTION = 'IPv6';

    /**
     * @param non-empty-string|null $description
     * @param string $ipv6
     * @param TagsInterface|null $tags
     * @throws TestValueExceptionInterface
     */
    public function __construct(?string $description, string $ipv6, ?TagsInterface $tags = null)
    {
        \assert(filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6), $ipv6);

        $tags ??= new Tags();
        $tags->add(TagEnum::IPv6);
        $tags->add(TagEnum::IP_ADDRESS);

        parent::__construct($description, $ipv6, $tags);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->value;
    }
}
