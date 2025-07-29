<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableSingleTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 20:54
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Values\Types;

use Iomywiab\Library\Testing\DataTypes\DateTime4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueNotImplementedException;
use Iomywiab\Library\Testing\Values\Tags\Tags;
use Iomywiab\Library\Testing\Values\Types\AbstractImmutableSingleTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableArrayTestValue;
use Iomywiab\Library\Testing\Values\Types\ImmutableBooleanTestValue;
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

#[CoversClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(TestValueExceptionInterface::class), UsesClass(TestValueNotImplementedException::class), UsesClass(TagEnum::class), UsesClass(Tags::class), UsesClass(AbstractImmutableSingleTestValue::class)]
#[UsesClass(ImmutableArrayTestValue::class)]
#[UsesClass(ImmutableBooleanTestValue::class)]
#[UsesClass(DateTime4Testing::class)]
#[UsesClass(ImmutableCharTestValue::class)]
#[UsesClass(ImmutableClosedResourceTestValue::class)]
#[UsesClass(ImmutableDateTimeTestValue::class)]
#[UsesClass(ImmutableFloatTestValue::class)]
#[UsesClass(ImmutableIntegerTestValue::class)]
#[UsesClass(ImmutableIpv4TestValue::class)]
#[UsesClass(ImmutableIpv6TestValue::class)]
#[UsesClass(ImmutableNullTestValue::class)]
#[UsesClass(ImmutableObjectTestValue::class)]
#[UsesClass(ImmutableOpenResourceTestValue::class)]
#[UsesClass(ImmutableStringTestValue::class)]
class AbstractImmutableSingleTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetTags(): void
    {
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        self::assertSame('ARRAY,STRING', (string)$testValue->getTags());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetTitle(): void
    {
        $testValue = new ImmutableArrayTestValue(null, ['testValue']);
        self::assertSame('array: [0=>testValue]', $testValue->getTitle());

        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        self::assertSame('array(testDescription): [0=>testValue]', $testValue->getTitle());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetValueByTag(): void
    {
        $value1 = new ImmutableArrayTestValue('test', ['a' => 1, 'b' => 2]);
        self::assertEquals(['a' => 1, 'b' => 2], $value1->getValueByTag(TagEnum::ARRAY));

        $value2 = new ImmutableBooleanTestValue('test', true);
        self::assertTrue($value2->getValueByTag(TagEnum::BOOLEAN));
        self::assertSame('true', $value2->getValueByTag(TagEnum::BOOL_STRING));

        $value3 = new ImmutableCharTestValue('test', 'X');
        self::assertSame('X', $value3->getValueByTag(TagEnum::CAPITAL_LETTER));
        self::assertSame('X', $value3->getValueByTag(TagEnum::CHAR));
        self::assertSame('X', $value3->getValueByTag(TagEnum::LETTER));
        self::assertSame('X', $value3->getValueByTag(TagEnum::STRING));
        self::assertSame('X', $value3->getValueByTag(TagEnum::STRING_UPPER));

        $closedResource = fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            fclose($closedResource);
        }
        $value25 = new ImmutableClosedResourceTestValue('test', $closedResource);
        self::assertSame($closedResource, $value25->getValueByTag(TagEnum::CLOSED_RESOURCE));

        $dt = new DateTime4Testing();
        $value26 = new ImmutableDateTimeTestValue('test', $dt);
        self::assertSame($dt, $value26->getValueByTag(TagEnum::DATETIME));
        self::assertSame($dt, $value26->getValueByTag(TagEnum::OBJECT));

        $value4 = new ImmutableCharTestValue('test', '1');
        self::assertSame('1', $value4->getValueByTag(TagEnum::DIGIT));

        $value5 = new ImmutableStringTestValue('test', 'example.org');
        self::assertSame('example.org', $value5->getValueByTag(TagEnum::DOMAIN));

        $value6 = new ImmutableStringTestValue('test', 'user@example.org');
        self::assertSame('user@example.org', $value6->getValueByTag(TagEnum::EMAIL));

        $value7 = new ImmutableStringTestValue('test', '');
        self::assertSame('', $value7->getValueByTag(TagEnum::EMPTY));

        $value8 = new ImmutableObjectTestValue('test', IntEnum4Testing::ONE);
        self::assertSame(IntEnum4Testing::ONE, $value8->getValueByTag(TagEnum::ENUM));
        self::assertSame(IntEnum4Testing::ONE, $value8->getValueByTag(TagEnum::ENUM_INT));

        $value9 = new ImmutableObjectTestValue('test', StringEnum4Testing::ONE);
        self::assertSame(StringEnum4Testing::ONE, $value9->getValueByTag(TagEnum::ENUM_STRING));

        $exc = new \Exception('test');
        $value10 = new ImmutableObjectTestValue('test', $exc);
        self::assertSame($exc, $value10->getValueByTag(TagEnum::EXCEPTION));

        $value11 = new ImmutableFloatTestValue('test', 1.2);
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT));
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT_NOT_NEGATIVE));
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT_POSITIVE));

        $value12 = new ImmutableFloatTestValue('test', -1.2);
        self::assertSame(-1.2, $value12->getValueByTag(TagEnum::FLOAT_NEGATIVE));

        $value13 = new ImmutableFloatTestValue('test', 1.0);
        self::assertSame(1.0, $value13->getValueByTag(TagEnum::FLOAT_WITH_INT_VALUE));

        $value14 = new ImmutableIntegerTestValue('test', 7);
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER));
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER_NOT_NEGATIVE));
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER_POSITIVE));
        self::assertSame(7, $value14->getValueByTag(TagEnum::PRIME));

        $value15 = new ImmutableIntegerTestValue('test', -1);
        self::assertSame(-1, $value15->getValueByTag(TagEnum::INTEGER_NEGATIVE));

        $value16 = new ImmutableIpv4TestValue('test', '127.0.0.1');
        self::assertSame('127.0.0.1', $value16->getValueByTag(TagEnum::IP_ADDRESS));
        self::assertSame('127.0.0.1', $value16->getValueByTag(TagEnum::IPv4));

        $value17 = new ImmutableIpv6TestValue('test', '::1');
        self::assertSame('::1', $value17->getValueByTag(TagEnum::IPv6));

        $value18 = new ImmutableStringTestValue('test', '00:1A:2B:3C:4D:5E');
        self::assertSame('00:1A:2B:3C:4D:5E', $value18->getValueByTag(TagEnum::MAC));

        $value19 = new ImmutableNullTestValue('test', null);
        self::assertNull($value19->getValueByTag(TagEnum::NULL));

        $openResource = fopen('php://memory', 'rb');
        $value20 = new ImmutableOpenResourceTestValue('test', $openResource);
        self::assertSame($openResource, $value20->getValueByTag(TagEnum::RESOURCE));

        $value21 = new ImmutableStringTestValue('test', 'a');
        self::assertSame('a', $value21->getValueByTag(TagEnum::SMALL_LETTER));
        self::assertSame('a', $value21->getValueByTag(TagEnum::STRING_LOWER));

        $value22 = new ImmutableStringTestValue('test', '1.2');
        self::assertSame('1.2', $value22->getValueByTag(TagEnum::STRING_FLOAT));

        $value23 = new ImmutableStringTestValue('test', '1');
        self::assertSame('1', $value23->getValueByTag(TagEnum::STRING_INTEGER));
        self::assertSame('1', $value23->getValueByTag(TagEnum::STRING_NUMERIC));

        $value24 = new ImmutableStringTestValue('test', 'https://www.example.ord');
        self::assertSame('https://www.example.ord', $value24->getValueByTag(TagEnum::URL));
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testStringable(): void
    {
        self::assertSame('[0=>testValue]', (string)new ImmutableArrayTestValue('testDescription', ['testValue']));
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToArray(): void
    {
        $testValue = new ImmutableBooleanTestValue('testDescription', true);
        self::assertSame([true], $testValue->toArray());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToBool(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toBool();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToFloat(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toFloat();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToInt(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toInt();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToObject(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toObject();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToRawValue(): void
    {
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        self::assertSame(['testValue'], $testValue->toRawValue());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToResource(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValue('testDescription', ['testValue']);
        $testValue->toResource();
    }

}
