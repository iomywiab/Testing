<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValuesTest.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:26
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Iomywiab\Library\Testing\Values\Enums\SubstitutionEnum;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\TestValues;
use PHPUnit\Framework\TestCase;

class TestValuesTest extends TestCase
{
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
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testByTemplate(): void
    {
        $values = TestValues::byTemplate([true, SubstitutionEnum::KEY, SubstitutionEnum::VALUE, 'test'], TagEnum::NULL);
        $expected = [
            'null' => [true, 'null', null, 'test'],
        ];
        self::assertEquals($expected, $values);

        $values = TestValues::byTemplate([true, 1, SubstitutionEnum::VALUE, 'test'], TagEnum::PRIME);
        $expected = [
            'prime of prime: (smallest signed 1 byte prime number) -127' => [true, 1, -127, 'test'],
            'prime of prime: (negative prime number) -7' => [true, 1, -7, 'test'],
            'prime of prime: (greatest even negative prime number) -2' => [true, 1, -2, 'test'],
            'prime of prime: (smallest even positive prime number) 2' => [true, 1, 2, 'test'],
            'prime of prime: (positive prime number) 7' => [true, 1, 7, 'test'],
            'prime of prime: (signed 4 byte prime number) 2147483647' => [true, 1, 2147483647, 'test'],
        ];

        self::assertEquals($expected, $values);
    }

    ///**
    // * @return void
    // */
    //public function testGetCombination(): void
    //{
    //    $valuesArr = [1, 2, 3, 4];
    //    for ($dimension = 1; $dimension <= 4; $dimension++) {
    //        $combinationsArr = TestValues::getCombination($valuesArr, $dimension);
    //        self::assertIsArray($combinationsArr);
    //        self::assertCount(\count($valuesArr) ** $dimension, $combinationsArr);
    //    }
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetCombinationOfEmptyArray(): void
    //{
    //    $this->expectException(TestValueException::class);
    //    TestValues::getCombination([], 3);
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetCombinationTooSmall0(): void
    //{
    //    $this->expectException(TestValueException::class);
    //    TestValues::getCombination([1], 0);
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetCombinationTooSmallNegative(): void
    //{
    //    $this->expectException(TestValueException::class);
    //    TestValues::getCombination([1], -1);
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetCombinationTooSmall5(): void
    //{
    //    $this->expectException(TestValueException::class);
    //    TestValues::getCombination([1], 5);
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetAsDataProvider(): void
    //{
    //    $valuesArr = TestValues::getForDataProvider(TestValueType::cases());
    //    self::assertIsArray($valuesArr);
    //
    //    foreach ($valuesArr as $item) {
    //        self::assertIsArray($item);
    //    }
    //}
    //
    ///**
    // * @return void
    // */
    //public function testAllOrNothing(): void
    //{
    //    // whitelist
    //    $allValuesArr = TestValues::all();
    //
    //    $typesArr = TestValues::get();
    //    self::assertEquals($allValuesArr, $typesArr);
    //
    //    /** @noinspection PhpRedundantOptionalArgumentInspection */
    //    $typesArr = TestValues::get(null);
    //    self::assertEquals($allValuesArr, $typesArr);
    //
    //    $typesArr = TestValues::get([]);
    //    self::assertEquals($allValuesArr, $typesArr);
    //
    //    $typesArr = TestValues::get(TestValueType::cases());
    //    self::assertEquals($allValuesArr, $typesArr);
    //
    //    // blacklist
    //    self::assertEmpty(TestValues::get(blacklist: TestValueType::cases()));
    //    self::assertEmpty(TestValues::get(null, TestValueType::cases()));
    //    self::assertEmpty(TestValues::get([], TestValueType::cases()));
    //    self::assertEmpty(TestValues::get(TestValueType::cases(), TestValueType::cases()));
    //}
    //
    ///**
    // * @return void
    // */
    //public function testGetTypes(): void
    //{
    //    $allTypesArr = TestValueType::cases();
    //
    //    $whitelistArr = [];
    //    $blacklistArr = [];
    //    $expectedArr = [];
    //
    //    foreach ($allTypesArr as $type) {
    //        $whitelistArr[] = $type;
    //        $expectedArr[] = $type;
    //        self::assertEquals($expectedArr, TestValues::getTypes($whitelistArr, $blacklistArr));
    //    }
    //
    //    foreach ($allTypesArr as $type) {
    //        $blacklistArr[] = $type;
    //        $index = \array_search($type, $expectedArr, true);
    //        if (false !== $index) {
    //            unset($expectedArr[$index]);
    //        }
    //        self::assertEquals($expectedArr, TestValues::getTypes($whitelistArr, $blacklistArr));
    //    }
    //}
    ///**
    // * @return array[]
    // */
    //public static function provideTestDataForDataProvider(): array
    //{
    //    return [
    //        [0, [123]],
    //        [0, [123, 456]],
    //        [1, [123, 456]],
    //        [0, [123, 456, 789]],
    //        [1, [123, 456, 789]],
    //        [2, [123, 456, 789]],
    //    ];
    //}
    //
    //public function testPrint(): void
    //{
    //    $table = [];
    //    foreach (ImmutableTestValues::getValues() as $testValue) {
    //        $table[] = [
    //            $testValue->getTitle(),
    //            $testValue->toString(),
    //            $testValue->getTagsAsString(),
    //        ];
    //    }
    //    Format4Testing::printTable($table);
    //
    //    $table = [];
    //    foreach (ImmutableTestValues::get() as $key => $testValue) {
    //        $table[] = [
    //            $key,
    //            match (true) {
    //                \is_array($testValue) => 'Array',//\json_encode($testValue, \JSON_THROW_ON_ERROR),
    //                $testValue instanceof \DateTime => $testValue->format(\DateTime::ATOM),
    //                $testValue instanceof \Reflection => 'reflection',
    //                \is_object($testValue) => \get_class($testValue),//\serialize($testValue),
    //                \is_resource($testValue) => \get_resource_type($testValue),
    //                default => (string)$testValue,
    //            }
    //        ];
    //    }
    //    Format4Testing::printTable($table);
    //
    //    self::assertTrue(true);
    //}

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

}
