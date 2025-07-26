<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValuesTest.php
 * Project: Testing
 * Modified at: 26/07/2025, 14:37
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Iomywiab\Library\Testing\Values\AbstractImmutableTestValues;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\ImmutableTestValues;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\TestValues;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableArrayTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableBooleanTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableBoolStringTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableCharTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableClosedResourceTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableDateTimeTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableFloatTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableIntegerTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableIpv4TestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableIpv6TestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableNullTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableObjectTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableOpenResourceTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableStringTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TestValues::class)]
#[UsesClass(AbstractImmutableTestValues::class), UsesClass(Tags::class), UsesClass(AbstractImmutableSingleTestValue::class), UsesClass(Format4Testing::class), UsesClass(TagEnum::class), UsesClass(ImmutableTestValues::class), UsesClass(ImmutableArrayTestValue::class), UsesClass(ImmutableBoolStringTestValue::class), UsesClass(ImmutableBooleanTestValue::class), UsesClass(ImmutableCharTestValue::class), UsesClass(ImmutableClosedResourceTestValue::class), UsesClass(ImmutableDateTimeTestValue::class), UsesClass(ImmutableFloatTestValue::class), UsesClass(ImmutableIntegerTestValue::class), UsesClass(ImmutableIpv4TestValue::class), UsesClass(ImmutableIpv6TestValue::class), UsesClass(ImmutableNullTestValue::class), UsesClass(ImmutableObjectTestValue::class), UsesClass(ImmutableOpenResourceTestValue::class), UsesClass(ImmutableStringTestValue::class)]
class TestValuesTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     * @throws \JsonException
     */
    public function testAll(): void
    {
        $allTags = TagEnum::cases();
        $this->checkArrays([
            TestValues::get(),
            TestValues::get($allTags),
            TestValues::getWithout([])
        ], $allTags);

        $inverseTags = (new Tags($allTags))->getInverse()->cases();
        self::assertEmpty($inverseTags);
        $this->checkArrays([
            TestValues::get(null, $allTags),
            TestValues::getWithout($allTags)
        ], $inverseTags);
    }

    /**
     * @param list<array<non-empty-string,mixed>> $arrays
     * @param list<TagEnum> $tags
     * @return void
     * @throws \JsonException
     */
    private function checkArrays(array $arrays, array $tags): void
    {
        self::assertNotEmpty($arrays);
        $firstArray = null;
        foreach ($arrays as $keyofArray => $array) {
            self::assertIsArray($array, $keyofArray.'=>'.Format4Testing::toString($array));
            foreach ($array as $key => $value) {
                self::assertIsString($key);
                if ('resource (closed)' === \gettype($value)) {
                    continue;
                }
                $isFound = false;
                foreach ($tags as $tag) {
                    if ($tag->isMine($value)) {
                        $isFound = true;
                        break;
                    }
                }
                self::assertTrue($isFound, $keyofArray.'=>'.\gettype($value).':'.Format4Testing::toString($value).', '.Format4Testing::toString($tags));
            }
            if (null === $firstArray) {
                $firstArray = $array;
            }
            self::assertSameSize($firstArray, $array);
        }
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testCompleteness(): void
    {
        $notFound = TagEnum::cases();
        $values = TestValues::getValues();
        foreach ($values as $value) {
            $tags = $value->getTags();
            foreach ($tags->cases() as $tag) {
                $key = \array_search($tag, $notFound, true);
                if (false !== $key) {
                    unset($notFound[$key]);
                }
            }
        }
        $hint = (string)(new Tags($notFound));
        self::assertEmpty($notFound, $hint);
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     * @throws \JsonException
     */
    public function testSingleTags(): void
    {
        $this->checkSingleTag(TestValues::arrays(), TagEnum::ARRAY);
        $this->checkSingleTag(TestValues::booleans(), TagEnum::BOOLEAN);
        $this->checkSingleTag(TestValues::empties(), TagEnum::EMPTY);
        $this->checkSingleTag(TestValues::floats(), TagEnum::FLOAT);
        $this->checkSingleTag(TestValues::integers(), TagEnum::INTEGER);
        $this->checkSingleTag(TestValues::ipAddresses(), TagEnum::IP_ADDRESS);
        $this->checkSingleTag(TestValues::ipv4Addresses(), TagEnum::IPv4);
        $this->checkSingleTag(TestValues::ipv6Addresses(), TagEnum::IPv6);
        $this->checkSingleTag(TestValues::nulls(), TagEnum::NULL);
        $this->checkSingleTag(TestValues::resources(), TagEnum::RESOURCE);
        $this->checkSingleTag(TestValues::objects(), TagEnum::OBJECT);
        $this->checkSingleTag(TestValues::strings(), TagEnum::STRING);
    }

    /**
     * @param array<non-empty-string,mixed> $values
     * @param TagEnum $enum
     * @return void
     * @throws TestValueExceptionInterface
     * @throws \JsonException
     */
    private function checkSingleTag(array $values, TagEnum $enum): void
    {
        $tags = new Tags($enum);
        $inverseTags = $tags->getInverse();

        $array1 = TestValues::get($enum);
        $this->checkArrays([$values, $array1], [$enum]);

        $array1 = TestValues::get(null, $inverseTags);
        $array2 = TestValues::getWithout($inverseTags);
        $this->checkArrays([$array1, $array2], [$enum]);

        $array1 = TestValues::get($inverseTags, $enum);
        $this->checkArrays([$array1], $inverseTags->cases());

        $array1 = TestValues::get(null, $enum);
        $array2 = TestValues::getWithout($enum);
        $this->checkArrays([$array1, $array2], $inverseTags->cases());
    }

    public function testString(): void
    {
        $array = TestValues::get(null, [TagEnum::STRING]);
        self::assertNotEmpty($array);
    }
}
