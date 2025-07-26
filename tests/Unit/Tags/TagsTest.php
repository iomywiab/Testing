<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Tags.php
 * Project: Testing
 * Modified at: 21/07/2025, 11:44
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Tags;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tags::class)]
class TagsTest extends TestCase
{
    /**
     * @param TagsInterface $tags
     * @param array<array-key,TagEnum> $expectedTags
     * @return void
     */
    private function checkTags(TagsInterface $tags, array $expectedTags): void
    {

        $bitmask = 0;
        foreach ($expectedTags as $expectedTag) {
            self::assertInstanceOf(TagEnum::class, $expectedTag);
            self::assertTrue($tags->contains($expectedTag));
            $bitmask |= $expectedTag->value;
        }
        self::assertSame($bitmask, $tags->getBitmask());
        self::assertSame(0 === \count($expectedTags), $tags->isEmpty());

        $cases = $tags->cases();
        self::assertSameSize($expectedTags, $cases);
        //self::assertEquals($expectedTags, $cases);
    }

    /**
     *
     * @param TagsInterface|TagEnum|array<array-key,TagEnum>|null $parameters
     * @param list<TagEnum> $expectedTags
     * @return void
     * @dataProvider provideTestDataForConstructor
     */
    public function testConstructor(TagsInterface|TagEnum|array|null $parameters, array $expectedTags): void
    {
        $tags = new Tags($parameters);
        $this->checkTags($tags, $expectedTags);
    }

    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestDataForConstructor(): array
    {
        return [
            [null, []],
            [TagEnum::INTEGER, [TagEnum::INTEGER]],
            [[TagEnum::INTEGER, TagEnum::STRING], [TagEnum::INTEGER, TagEnum::STRING]],
            [new Tags(), []],
            [new Tags(null), []],
            [new Tags(TagEnum::INTEGER), [TagEnum::INTEGER]],
            [new Tags([TagEnum::INTEGER]), [TagEnum::INTEGER]],
            [new Tags([TagEnum::INTEGER, TagEnum::STRING]), [TagEnum::INTEGER, TagEnum::STRING]],
        ];
    }

    public function testEmpty(): void
    {
        $tags = new Tags();
        self::assertTrue($tags->isEmpty());
        self::assertSame(0, $tags->getBitmask());
        self::assertSame([], $tags->cases());
        foreach (TagEnum::cases() as $case) {
            self::assertFalse($tags->contains($case));
        }
        self::assertFalse($tags->contains(TagEnum::INTEGER));
        self::assertFalse($tags->contains(null));
    }

    public function testAddRemove(): void
    {
        $tags = new Tags();
        $cases = TagEnum::cases();
        $included = [];

        foreach ($cases as $case) {
            $tags->add($case);
            $included[] = $case;
            $this->checkTags($tags, $included);
        }
        $tags->add(null);
        self::assertSameSize($cases, $included);

        foreach ($cases as $key => $case) {
            $tags->remove($case);
            unset($included[$key]);
            $this->checkTags($tags, $included);
        }
        $tags->remove(null);
        self::assertSame([], $included);
    }

    /**
     * @param list<TagEnum> $tags
     * @param list<TagEnum> $includedTags
     * @param list<TagEnum> $excludedTags
     * @param list<TagEnum> $result
     * @return void
     * @dataProvider provideTestDataForFilter
     */
    public function testFilter(array $tags, array $includedTags, array $excludedTags, array $result): void
    {
        $tagsObject = new Tags($tags);
        $filtered = $tagsObject->getFiltered($includedTags, $excludedTags);
        $filteredCases = $filtered->cases();
        self::assertEquals($result, $filteredCases);
    }

    /**
     * @return non-empty-list<non-empty-list<mixed>>
     */
    public static function provideTestDataForFilter(): array
    {
        return [
            [[], [], [], []],
            [[], [TagEnum::FLOAT], [], []],
            [[], [], [TagEnum::INTEGER], []],
            [[], [TagEnum::FLOAT], [TagEnum::INTEGER], []],

            [[TagEnum::FLOAT], [], [], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT], [TagEnum::FLOAT], [], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT], [], [TagEnum::FLOAT], []],

            [[TagEnum::FLOAT,TagEnum::ENUM], [], [], [TagEnum::ENUM,TagEnum::FLOAT]],
            [[TagEnum::FLOAT,TagEnum::ENUM], [TagEnum::FLOAT,TagEnum::ENUM], [], [TagEnum::ENUM,TagEnum::FLOAT]],
            [[TagEnum::FLOAT,TagEnum::ENUM], [TagEnum::ENUM], [], [TagEnum::ENUM]],
            [[TagEnum::FLOAT,TagEnum::ENUM], [TagEnum::FLOAT], [], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT,TagEnum::ENUM], [], [TagEnum::FLOAT,TagEnum::ENUM], []],
            [[TagEnum::FLOAT,TagEnum::ENUM], [], [TagEnum::ENUM], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT,TagEnum::ENUM], [], [TagEnum::FLOAT], [TagEnum::ENUM]],
        ];
    }

    public function testStringable(): void
    {
        $tags = new Tags([TagEnum::ENUM, TagEnum::FLOAT]);
        self::assertSame('ENUM,FLOAT', (string)$tags);
    }
}
