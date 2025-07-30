<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValuesTest.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:49
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
use Iomywiab\Library\Testing\Values\ValueObjects\AbstractImmutableTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableArrayTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableBooleanTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableBoolStringTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableCharTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableClosedResourceTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableDateTimeTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableFloatTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableIntegerTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableIpv4TestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableIpv6TestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableNullTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableObjectTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableOpenResourceTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutablePrimeTestValue;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableStringTestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImmutableTestValues::class)]
#[UsesClass(Tags::class), UsesClass(AbstractImmutableTestValueObject::class), UsesClass(Format4Testing::class), UsesClass(TagEnum::class), UsesClass(ImmutableTestValues::class), UsesClass(ImmutableArrayTestValueObject::class), UsesClass(ImmutableBoolStringTestValueObject::class), UsesClass(ImmutableBooleanTestValueObject::class), UsesClass(ImmutableCharTestValueObject::class), UsesClass(ImmutableClosedResourceTestValueObject::class), UsesClass(ImmutableDateTimeTestValueObject::class), UsesClass(ImmutableFloatTestValueObject::class), UsesClass(ImmutableIntegerTestValueObject::class), UsesClass(ImmutableIpv4TestValueObject::class), UsesClass(ImmutableIpv6TestValueObject::class), UsesClass(ImmutableNullTestValueObject::class), UsesClass(ImmutableObjectTestValueObject::class), UsesClass(ImmutableOpenResourceTestValueObject::class)]
#[UsesClass(Filter::class)]
#[UsesClass(ImmutableStringTestValueObject::class)]
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
     * @param list<\Generator<non-empty-string,mixed>> $arrays
     * @param list<TagEnum> $tags
     * @return void
     * @throws \JsonException
     */
    private function checkArrays(array $arrays, array $tags): void
    {
        self::assertNotEmpty($arrays);
        $firstArraySize = null;
        foreach ($arrays as $keyofArray => $array) {
            // @phpstan-ignore staticMethod.alreadyNarrowedType
            self::assertInstanceOf(\Generator::class, $array, 'key='.$keyofArray);
            $arraySize = 0;
            foreach ($array as $key => $value) {
                $arraySize++;
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
            if (null === $firstArraySize) {
                $firstArraySize = $arraySize;
            }
            self::assertSame($firstArraySize, $arraySize);
        }
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testCompleteness(): void
    {
        $notFound = TagEnum::cases();
        $values = (new ImmutableTestValues())->getValueObjects();
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
     * @param \Generator<non-empty-string,mixed> $values
     * @param TagEnum $enum
     * @return void
     * @throws TestValueExceptionInterface
     * @throws \JsonException
     */
    private function checkSingleTag(\Generator $values, TagEnum $enum): void
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
        $values = $testValues->get(null, [TagEnum::STRING]);
        self::assertNotEmpty(iterator_to_array($values, true));
    }
}
