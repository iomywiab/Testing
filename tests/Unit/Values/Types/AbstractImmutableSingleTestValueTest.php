<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: AbstractImmutableSingleTestValueTest.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:14
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
use Iomywiab\Library\Testing\Values\ValueObjects\AbstractImmutableTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableArrayTestValueObject;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableBooleanTestValueObject;
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
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableStringTestValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(TestValueExceptionInterface::class), UsesClass(TestValueNotImplementedException::class), UsesClass(TagEnum::class), UsesClass(Tags::class), UsesClass(AbstractImmutableTestValueObject::class)]
#[UsesClass(ImmutableArrayTestValueObject::class)]
#[UsesClass(ImmutableBooleanTestValueObject::class)]
#[UsesClass(DateTime4Testing::class)]
#[UsesClass(ImmutableCharTestValueObject::class)]
#[UsesClass(ImmutableClosedResourceTestValueObject::class)]
#[UsesClass(ImmutableDateTimeTestValueObject::class)]
#[UsesClass(ImmutableFloatTestValueObject::class)]
#[UsesClass(ImmutableIntegerTestValueObject::class)]
#[UsesClass(ImmutableIpv4TestValueObject::class)]
#[UsesClass(ImmutableIpv6TestValueObject::class)]
#[UsesClass(ImmutableNullTestValueObject::class)]
#[UsesClass(ImmutableObjectTestValueObject::class)]
#[UsesClass(ImmutableOpenResourceTestValueObject::class)]
#[UsesClass(ImmutableStringTestValueObject::class)]
class AbstractImmutableSingleTestValueTest extends TestCase
{
    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetTags(): void
    {
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        self::assertSame('ARRAY,STRING', (string)$testValue->getTags());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetTitle(): void
    {
        $testValue = new ImmutableArrayTestValueObject(null, ['testValue']);
        self::assertSame('array: [0=>testValue]', $testValue->getTitle());

        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        self::assertSame('array(testDescription): [0=>testValue]', $testValue->getTitle());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testGetValueByTag(): void
    {
        $value1 = new ImmutableArrayTestValueObject('test', ['a' => 1, 'b' => 2]);
        self::assertEquals(['a' => 1, 'b' => 2], $value1->getValueByTag(TagEnum::ARRAY));

        $value2 = new ImmutableBooleanTestValueObject('test', true);
        self::assertTrue($value2->getValueByTag(TagEnum::BOOLEAN));
        self::assertSame('true', $value2->getValueByTag(TagEnum::BOOL_STRING));

        $value3 = new ImmutableCharTestValueObject('test', 'X');
        self::assertSame('X', $value3->getValueByTag(TagEnum::CAPITAL_LETTER));
        self::assertSame('X', $value3->getValueByTag(TagEnum::CHAR));
        self::assertSame('X', $value3->getValueByTag(TagEnum::LETTER));
        self::assertSame('X', $value3->getValueByTag(TagEnum::STRING));
        self::assertSame('X', $value3->getValueByTag(TagEnum::STRING_UPPER));

        $closedResource = fopen('php://memory', 'rb');
        if (false !== $closedResource) {
            fclose($closedResource);
        }
        $value25 = new ImmutableClosedResourceTestValueObject('test', $closedResource);
        self::assertSame($closedResource, $value25->getValueByTag(TagEnum::CLOSED_RESOURCE));

        $dt = new DateTime4Testing();
        $value26 = new ImmutableDateTimeTestValueObject('test', $dt);
        self::assertSame($dt, $value26->getValueByTag(TagEnum::DATETIME));
        self::assertSame($dt, $value26->getValueByTag(TagEnum::OBJECT));

        $value4 = new ImmutableCharTestValueObject('test', '1');
        self::assertSame('1', $value4->getValueByTag(TagEnum::DIGIT));

        $value5 = new ImmutableStringTestValueObject('test', 'example.org');
        self::assertSame('example.org', $value5->getValueByTag(TagEnum::DOMAIN));

        $value6 = new ImmutableStringTestValueObject('test', 'user@example.org');
        self::assertSame('user@example.org', $value6->getValueByTag(TagEnum::EMAIL));

        $value7 = new ImmutableStringTestValueObject('test', '');
        self::assertSame('', $value7->getValueByTag(TagEnum::EMPTY));

        $value8 = new ImmutableObjectTestValueObject('test', IntEnum4Testing::ONE);
        self::assertSame(IntEnum4Testing::ONE, $value8->getValueByTag(TagEnum::ENUM));
        self::assertSame(IntEnum4Testing::ONE, $value8->getValueByTag(TagEnum::ENUM_INT));

        $value9 = new ImmutableObjectTestValueObject('test', StringEnum4Testing::ONE);
        self::assertSame(StringEnum4Testing::ONE, $value9->getValueByTag(TagEnum::ENUM_STRING));

        $exc = new \Exception('test');
        $value10 = new ImmutableObjectTestValueObject('test', $exc);
        self::assertSame($exc, $value10->getValueByTag(TagEnum::EXCEPTION));

        $value11 = new ImmutableFloatTestValueObject('test', 1.2);
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT));
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT_NOT_NEGATIVE));
        self::assertSame(1.2, $value11->getValueByTag(TagEnum::FLOAT_POSITIVE));

        $value12 = new ImmutableFloatTestValueObject('test', -1.2);
        self::assertSame(-1.2, $value12->getValueByTag(TagEnum::FLOAT_NEGATIVE));

        $value13 = new ImmutableFloatTestValueObject('test', 1.0);
        self::assertSame(1.0, $value13->getValueByTag(TagEnum::FLOAT_WITH_INT_VALUE));

        $value14 = new ImmutableIntegerTestValueObject('test', 7);
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER));
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER_NOT_NEGATIVE));
        self::assertSame(7, $value14->getValueByTag(TagEnum::INTEGER_POSITIVE));
        self::assertSame(7, $value14->getValueByTag(TagEnum::PRIME));

        $value15 = new ImmutableIntegerTestValueObject('test', -1);
        self::assertSame(-1, $value15->getValueByTag(TagEnum::INTEGER_NEGATIVE));

        $value16 = new ImmutableIpv4TestValueObject('test', '127.0.0.1');
        self::assertSame('127.0.0.1', $value16->getValueByTag(TagEnum::IP_ADDRESS));
        self::assertSame('127.0.0.1', $value16->getValueByTag(TagEnum::IPv4));

        $value17 = new ImmutableIpv6TestValueObject('test', '::1');
        self::assertSame('::1', $value17->getValueByTag(TagEnum::IPv6));

        $value18 = new ImmutableStringTestValueObject('test', '00:1A:2B:3C:4D:5E');
        self::assertSame('00:1A:2B:3C:4D:5E', $value18->getValueByTag(TagEnum::MAC));

        $value19 = new ImmutableNullTestValueObject('test', null);
        self::assertNull($value19->getValueByTag(TagEnum::NULL));

        $openResource = fopen('php://memory', 'rb');
        $value20 = new ImmutableOpenResourceTestValueObject('test', $openResource);
        self::assertSame($openResource, $value20->getValueByTag(TagEnum::RESOURCE));

        $value21 = new ImmutableStringTestValueObject('test', 'a');
        self::assertSame('a', $value21->getValueByTag(TagEnum::SMALL_LETTER));
        self::assertSame('a', $value21->getValueByTag(TagEnum::STRING_LOWER));

        $value22 = new ImmutableStringTestValueObject('test', '1.2');
        self::assertSame('1.2', $value22->getValueByTag(TagEnum::STRING_FLOAT));

        $value23 = new ImmutableStringTestValueObject('test', '1');
        self::assertSame('1', $value23->getValueByTag(TagEnum::STRING_INTEGER));
        self::assertSame('1', $value23->getValueByTag(TagEnum::STRING_NUMERIC));

        $value24 = new ImmutableStringTestValueObject('test', 'https://www.example.ord');
        self::assertSame('https://www.example.ord', $value24->getValueByTag(TagEnum::URL));
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testStringable(): void
    {
        self::assertSame('[0=>testValue]', (string)new ImmutableArrayTestValueObject('testDescription', ['testValue']));
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToArray(): void
    {
        $testValue = new ImmutableBooleanTestValueObject('testDescription', true);
        self::assertSame([true], $testValue->toArray());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToBool(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        $testValue->toBool();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToFloat(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        $testValue->toFloat();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToInt(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        $testValue->toInt();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToObject(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        $testValue->toObject();
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToRawValue(): void
    {
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        self::assertSame(['testValue'], $testValue->toRawValue());
    }

    /**
     * @return void
     * @throws TestValueExceptionInterface
     */
    public function testToResource(): void
    {
        $this->expectException(TestValueNotImplementedException::class);
        $testValue = new ImmutableArrayTestValueObject('testDescription', ['testValue']);
        $testValue->toResource();
    }

}
