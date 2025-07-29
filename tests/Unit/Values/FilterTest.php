<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: FilterTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 16:23
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Filter;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Filter::class)]
#[UsesClass(TagEnum::class)]
#[UsesClass(Tags::class)]
class FilterTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetCacheKey(): void
    {
        foreach (TagEnum::cases() as $include) {
            foreach (TagEnum::cases() as $exclude) {
                $filter = new Filter($include, $exclude);
                self::assertSame($include->value.'-'.$exclude->value, $filter->getCacheKey());
            }
        }
    }

    /**
     * @return void
     */
    public function testIsIncluded(): void
    {
        foreach (TagEnum::cases() as $include) {
            foreach (TagEnum::cases() as $exclude) {
                $filter = new Filter($include, $exclude);
                $hint = 'include='.$include->name.' excluded='.$exclude->name;
                self::assertTrue(($include === $exclude) || $filter->isIncluded($include), $hint);
                self::assertFalse($filter->isIncluded($exclude), $hint);
            }
        }
    }
}
