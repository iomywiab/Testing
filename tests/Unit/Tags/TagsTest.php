<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TagsTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 16:09
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Tags;

use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tags::class)]
#[UsesClass(TagEnum::class)]
class TagsTest extends TestCase
{
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

            [[TagEnum::FLOAT, TagEnum::ENUM], [], [], [TagEnum::ENUM, TagEnum::FLOAT]],
            [[TagEnum::FLOAT, TagEnum::ENUM], [TagEnum::FLOAT, TagEnum::ENUM], [], [TagEnum::ENUM, TagEnum::FLOAT]],
            [[TagEnum::FLOAT, TagEnum::ENUM], [TagEnum::ENUM], [], [TagEnum::ENUM]],
            [[TagEnum::FLOAT, TagEnum::ENUM], [TagEnum::FLOAT], [], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT, TagEnum::ENUM], [], [TagEnum::FLOAT, TagEnum::ENUM], []],
            [[TagEnum::FLOAT, TagEnum::ENUM], [], [TagEnum::ENUM], [TagEnum::FLOAT]],
            [[TagEnum::FLOAT, TagEnum::ENUM], [], [TagEnum::FLOAT], [TagEnum::ENUM]],
        ];
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
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testFromData(): void
    {
        $tags = Tags::fromData('string');
        self::assertTrue($tags->contains(TagEnum::STRING));
        self::assertTrue($tags->contains(TagEnum::STRING_LOWER));
        self::assertFalse($tags->contains(TagEnum::INTEGER));
        self::assertFalse($tags->contains(TagEnum::EMPTY));
    }

    /**
     * @return void
     */
    public function testIntersections(): void
    {
        $intFloat = new Tags([TagEnum::INTEGER, TagEnum::FLOAT]);
        $intString = new Tags([TagEnum::INTEGER, TagEnum::STRING]);
        $floatEnum = new Tags([TagEnum::FLOAT, TagEnum::ENUM]);
        self::assertTrue($intFloat->intersects($intString));
        self::assertTrue($intString->intersects($intFloat));
        self::assertTrue($intFloat->intersects($floatEnum));
        self::assertTrue($floatEnum->intersects($intFloat));
        self::assertFalse($intString->intersects($floatEnum));
        self::assertFalse($floatEnum->intersects($intString));
        self::assertFalse($floatEnum->intersects(null));
    }

    /**
     * @return void
     */
    public function testInverse(): void
    {
        $tags = new Tags([]);
        $inverse = $tags->getInverse();
        self::assertSameSize($inverse->cases(), TagEnum::cases());
    }

    /**
     * @return void
     */
    public function testStringable(): void
    {
        $tags = new Tags([TagEnum::ENUM, TagEnum::FLOAT]);
        self::assertSame('ENUM,FLOAT', (string)$tags);
    }
}
