<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValuesTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 21:08
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Filter;
use Iomywiab\Library\Testing\Values\ImmutableTestValues;
use Iomywiab\Library\Testing\Values\Tags\Tags;
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
use Iomywiab\Library\Testing\Values\Types\ImmutablePrimeTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableStringTestValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableTestValues::class)]
#[UsesClass(Tags::class), UsesClass(AbstractImmutableSingleTestValue::class), UsesClass(Format4Testing::class), UsesClass(TagEnum::class), UsesClass(ImmutableTestValues::class), UsesClass(ImmutableArrayTestValue::class), UsesClass(ImmutableBoolStringTestValue::class), UsesClass(ImmutableBooleanTestValue::class), UsesClass(ImmutableCharTestValue::class), UsesClass(ImmutableClosedResourceTestValue::class), UsesClass(ImmutableDateTimeTestValue::class), UsesClass(ImmutableFloatTestValue::class), UsesClass(ImmutableIntegerTestValue::class), UsesClass(ImmutableIpv4TestValue::class), UsesClass(ImmutableIpv6TestValue::class), UsesClass(ImmutableNullTestValue::class), UsesClass(ImmutableObjectTestValue::class), UsesClass(ImmutableOpenResourceTestValue::class)]
#[UsesClass(Filter::class)]
#[UsesClass(ImmutableStringTestValue::class)]
#[UsesClass(ImmutablePrimeTestValue::class)]
class ImmutableTestValuesTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     * @throws \JsonException
     */
    public function testAll(): void
    {
        $testValues = new ImmutableTestValues();

        $allTags = TagEnum::cases();
        $this->checkArrays([
            $testValues->get(),
            $testValues->get($allTags),
            $testValues->getWithout([])
        ], $allTags);

        $inverseTags = (new Tags($allTags))->getInverse()->cases();
        self::assertEmpty($inverseTags);
        $this->checkArrays([
            $testValues->get(null, $allTags),
            $testValues->getWithout($allTags)
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
    public function testCache(): void
    {
        $testValues = new ImmutableTestValues();

        $values1 = $testValues->getValues([TagEnum::STRING]);
        $values2 = $testValues->getValues([TagEnum::STRING]);
        self::assertSame($values1, $values2);

        $strings1 = $testValues->strings();
        $strings2 = $testValues->strings();
        self::assertSame($strings1, $strings2);
        self::assertNotSame($strings1, $values1);
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testCompleteness(): void
    {
        $notFound = TagEnum::cases();
        $values = (new ImmutableTestValues())->getValues();
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
        $testValues = new ImmutableTestValues();
        $this->checkSingleTag($testValues->arrays(), TagEnum::ARRAY);
        $this->checkSingleTag($testValues->booleans(), TagEnum::BOOLEAN);
        $this->checkSingleTag($testValues->empties(), TagEnum::EMPTY);
        $this->checkSingleTag($testValues->floats(), TagEnum::FLOAT);
        $this->checkSingleTag($testValues->enums(), TagEnum::ENUM);
        $this->checkSingleTag($testValues->integers(), TagEnum::INTEGER);
        $this->checkSingleTag($testValues->ipAddresses(), TagEnum::IP_ADDRESS);
        $this->checkSingleTag($testValues->ipv4Addresses(), TagEnum::IPv4);
        $this->checkSingleTag($testValues->ipv6Addresses(), TagEnum::IPv6);
        $this->checkSingleTag($testValues->nulls(), TagEnum::NULL);
        $this->checkSingleTag($testValues->resources(), TagEnum::RESOURCE);
        $this->checkSingleTag($testValues->objects(), TagEnum::OBJECT);
        $this->checkSingleTag($testValues->strings(), TagEnum::STRING);
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
        $testValues = new ImmutableTestValues();

        $tags = new Tags($enum);
        $inverseTags = $tags->getInverse();

        $array1 = $testValues->get($enum);
        $this->checkArrays([$values, $array1], [$enum]);

        $array1 = $testValues->get(null, $inverseTags);
        $array2 = $testValues->getWithout($inverseTags);
        $this->checkArrays([$array1, $array2], [$enum]);

        $array1 = $testValues->get($inverseTags, $enum);
        $this->checkArrays([$array1], $inverseTags->cases());

        $array1 = $testValues->get(null, $enum);
        $array2 = $testValues->getWithout($enum);
        $this->checkArrays([$array1, $array2], $inverseTags->cases());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testString(): void
    {
        $testValues = new ImmutableTestValues();
        $array = $testValues->get(null, [TagEnum::STRING]);
        self::assertNotEmpty($array);
    }
}
