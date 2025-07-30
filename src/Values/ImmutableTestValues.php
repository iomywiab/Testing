<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValues.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:27
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\DataTypes\Enum4Testing;
use Iomywiab\Library\Testing\DataTypes\IntEnum4Testing;
use Iomywiab\Library\Testing\DataTypes\StringEnum4Testing;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;
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
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableSingleTestValueObjectInterface;
use Iomywiab\Library\Testing\Values\ValueObjects\ImmutableStringTestValueObject;

class ImmutableTestValues implements ImmutableTestValuesInterface
{
    /** @noinspection SpellCheckingInspection */
    private const ALL_CHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    ."^°!\"§$%&/()[]{}=?`´äÄöÖüÜ+*#',;.:-_\\\t|~@\n\r";

    private const TEST_FILE = __DIR__.'/../Fixtures/TestValuesFile.txt';

    /** @var array<non-empty-string,ImmutableSingleTestValueObjectInterface> $values */
    private readonly array $values;

    /**
     * @throws TestValueExceptionInterface
     */
    public function __construct()
    {
        $list = self::getValueObjectsList();
        $values = [];
        foreach ($list as $item) {
            $key = $item->getTitle();
            $values[$key] = $item;
        }
        \assert([] !== $values);
        $this->values = $values;
    }

    /**
     * @return list<ImmutableSingleTestValueObjectInterface>
     * @throws TestValueExceptionInterface
     * @noinspection SpellCheckingInspection
     */
    private static function getValueObjectsList(): array
    {
        /** @var list<ImmutableSingleTestValueObjectInterface> $values */
        $values = [];

        // ARRAY
        $values[] = new ImmutableArrayTestValueObject('empty', []);
        $values[] = new ImmutableArrayTestValueObject('non-empty-list', [1, 2]);
        $values[] = new ImmutableArrayTestValueObject('non-empty-array', [1 => 1, 2 => 2]);

        // BOOLEAN
        $values[] = new ImmutableBooleanTestValueObject(null, true);
        $values[] = new ImmutableBooleanTestValueObject(null, false);

        // BOOL STRING
        $values[] = new ImmutableBoolStringTestValueObject(null, 'true', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, '1', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'activated', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'active', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'enabled', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'on', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'yes', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'y', true);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'false', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, '0', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'deactivated', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'inactive', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'disabled', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'off', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'no', false);
        $values[] = new ImmutableBoolStringTestValueObject(null, 'n', false);

        // CHAR
        $length = \mb_strlen(self::ALL_CHARS);
        for ($i = 0; $i < $length; $i++) {
            $char = \mb_substr(self::ALL_CHARS, $i, 1);
            $values[] = new ImmutableCharTestValueObject(null, $char);
        }

        // DATETIME
        $tz = new \DateTimeZone('UTC');
        $values[] = new ImmutableDateTimeTestValueObject('first unix timestamp', '1970-01-01 00:00:00');
        $values[] = new ImmutableDateTimeTestValueObject('before 2000', '1999-12-31 23:59:59');
        $values[] = new ImmutableDateTimeTestValueObject('start of year 2000', '2000-01-01 00:00:00');
        $values[] = new ImmutableDateTimeTestValueObject('random date', '2020-01-02 03:04:05');
        $values[] = new ImmutableDateTimeTestValueObject('last unix timestamp', '2038-01-19 03:14:06');
        $values[] = new ImmutableDateTimeTestValueObject('now', 'now');
        $values[] = new ImmutableDateTimeTestValueObject('datetime object', new \DateTime('2000-01-01 00:00:00', $tz));

        // ENUM
        $values[] = new ImmutableObjectTestValueObject('UnitEnum', Enum4Testing::ONE);
        $values[] = new ImmutableObjectTestValueObject('IntBackedEnum', IntEnum4Testing::ONE);
        $values[] = new ImmutableObjectTestValueObject('StringIntEnum', StringEnum4Testing::ONE);

        // EXCEPTION
        $values[] = new ImmutableObjectTestValueObject('Exception', new \Exception());
        $values[] = new ImmutableObjectTestValueObject('RuntimeException', new \RuntimeException());
        $values[] = new ImmutableObjectTestValueObject('LogicException', new \LogicException());

        // FLOAT
        $values[] = new ImmutableFloatTestValueObject('-PHP_FLOAT_MAX', -PHP_FLOAT_MAX);
        $values[] = new ImmutableFloatTestValueObject('PHP_FLOAT_MIN', PHP_FLOAT_MIN);
        $values[] = new ImmutableFloatTestValueObject('PHP_FLOAT_MAX', PHP_FLOAT_MAX);
        $values[] = new ImmutableFloatTestValueObject(null, -1234567890.123456789);
        $values[] = new ImmutableFloatTestValueObject(null, 1234567890.123456789);
        $values[] = new ImmutableFloatTestValueObject(null, -9.123456789);
        $values[] = new ImmutableFloatTestValueObject(null, 9.123456789);
        $values[] = new ImmutableFloatTestValueObject(null, -1.2);
        $values[] = new ImmutableFloatTestValueObject(null, 1.2);
        $values[] = new ImmutableFloatTestValueObject(null, -0.1);
        $values[] = new ImmutableFloatTestValueObject(null, 0.1);
        $values[] = new ImmutableFloatTestValueObject(null, -1234567890.0);
        $values[] = new ImmutableFloatTestValueObject(null, 1234567890.0);
        $values[] = new ImmutableFloatTestValueObject(null, -7.0);
        $values[] = new ImmutableFloatTestValueObject(null, 7.0);
        $values[] = new ImmutableFloatTestValueObject(null, -1.0);
        $values[] = new ImmutableFloatTestValueObject(null, 1.0);
        $values[] = new ImmutableFloatTestValueObject(null, 0.0);

        // INTEGER
        $values[] = new ImmutableIntegerTestValueObject('PHP_INT_MIN', PHP_INT_MIN);
        $values[] = new ImmutableIntegerTestValueObject('min signed 4 byte - 1', -2147483649);
        $values[] = new ImmutableIntegerTestValueObject('min signed 4 byte', -2147483648);
        $values[] = new ImmutableIntegerTestValueObject('min signed 2 byte - 1', -32769);
        $values[] = new ImmutableIntegerTestValueObject('min signed 2 byte', -32768);
        $values[] = new ImmutableIntegerTestValueObject('min signed 1 byte - 1', -128);
        $values[] = new ImmutableIntegerTestValueObject('greatest int less than 0', -1);
        $values[] = new ImmutableIntegerTestValueObject('min unsigned', 0);
        $values[] = new ImmutableIntegerTestValueObject('smallest int greater than 0', 1);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 1 byte', 255);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 1 byte + 1', 256);
        $values[] = new ImmutableIntegerTestValueObject('max signed 2 byte', 32767);
        $values[] = new ImmutableIntegerTestValueObject('max signed 2 byte + 1', 32768);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 2 byte', 65535);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 2 byte + 1', 65536);
        $values[] = new ImmutableIntegerTestValueObject('max signed 4 byte + 1', 2147483648);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 4 byte', 4294967295);
        $values[] = new ImmutableIntegerTestValueObject('max unsigned 4 byte + 1', 4294967296);
        $values[] = new ImmutableIntegerTestValueObject('max signed 4 byte', 9223372036854775807);
        //$values[]=new ImmutableIntegerTestValue('max signed 4 byte + 1', (int)9223372036854775808); // would cause overflow
        $values[] = new ImmutableIntegerTestValueObject('PHP_INT_MAX', PHP_INT_MAX);

        // IPv4
        $values[] = new ImmutableIpv4TestValueObject('all', '0.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class A public: begin', '1.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class A public: end', '127.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class A private: start', '10.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class A private: end', '10.255.255.255');
        $values[] = new ImmutableIpv4TestValueObject('class A subnet mask', '255.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class B public: begin', '128.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class B public: end', '191.255.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class B private: begin', '172.16.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class B private: end', '172.31.255.255');
        $values[] = new ImmutableIpv4TestValueObject('class B subnet mask', '255.255.0.0');
        /** @noinspection SpellCheckingInspection */
        $values[] = new ImmutableIpv4TestValueObject('class B private APIPA: begin', '169.254.0.0');
        /** @noinspection SpellCheckingInspection */
        $values[] = new ImmutableIpv4TestValueObject('class B private APIPA: end', '169.254.255.255');
        $values[] = new ImmutableIpv4TestValueObject('class C public: begin', '192.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class C public: end', '223.255.255.0');
        $values[] = new ImmutableIpv4TestValueObject('class C private: begin', '192.168.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class C private: end', '192.168.255.255');
        $values[] = new ImmutableIpv4TestValueObject('class C subnet mask', '255.255.255.0');
        $values[] = new ImmutableIpv4TestValueObject('class D: begin', '224.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class D: end', '239.255.255.255');
        $values[] = new ImmutableIpv4TestValueObject('class E: begin', '240.0.0.0');
        $values[] = new ImmutableIpv4TestValueObject('class E: end', '255.255.255.255');
        $values[] = new ImmutableIpv4TestValueObject('broadcast', '255.255.255.255');
        $values[] = new ImmutableIpv4TestValueObject('Google DNS resolver', '8.8.8.8');

        // IPv6
        $values[] = new ImmutableIpv6TestValueObject('Loopback', '::1');
        //$values[] = new ImmutableIpv6TestValue('Link-Local', 'fe80::/10');
        //$values[] = new ImmutableIpv6TestValue('Unique Local', 'fc99::/7');
        //$values[] = new ImmutableIpv6TestValue('Global unicast', '2000::/3');
        //$values[] = new ImmutableIpv6TestValue('Multicast', 'ff00::/8');
        //$values[] = new ImmutableIpv6TestValue('Documentation', '2001:db8::/32');
        //$values[] = new ImmutableIpv6TestValue('IPv4-mapped #1', '::ffff:0:0/96');
        $values[] = new ImmutableIpv6TestValueObject('IPv4-mapped #2', '::ffff:192.168.1.1');
        $values[] = new ImmutableIpv6TestValueObject(null, '2001:0db8:85a3:08d3:1319:8a2e:0370:7334');

        // MAC
        $values[] = new ImmutableStringTestValueObject('MAC#1', '00:1A:2B:3C:4D:5E');
        $values[] = new ImmutableStringTestValueObject('MAC#2', '00-1A-2B-3C-4D-5E');
        $values[] = new ImmutableStringTestValueObject('MAC#3', 'AB:CD:EF:12:34:56:78');

        // NULL
        $values[] = new ImmutableNullTestValueObject(null, null);

        // OBJECT
        $values[] = new ImmutableObjectTestValueObject('stdClass', new \stdClass);

        // PRIME
        $values[] = new ImmutablePrimeTestValue('smallest signed 1 byte prime number', -127);
        $values[] = new ImmutablePrimeTestValue('negative prime number', -7);
        $values[] = new ImmutablePrimeTestValue('greatest even negative prime number', -2);
        $values[] = new ImmutablePrimeTestValue('smallest even positive prime number', 2);
        $values[] = new ImmutablePrimeTestValue('positive prime number', 7);
        $values[] = new ImmutablePrimeTestValue('signed 4 byte prime number', 2147483647);

        // RESOURCE
        $openFile = \fopen(self::TEST_FILE, 'rb');
        $closedFile = \fopen(self::TEST_FILE, 'rb');
        $openResource = \fopen('php://memory', 'rb');
        $closedResource = \fopen('php://memory', 'rb');
        if (false !== $closedFile) {
            \fclose($closedFile);
        }
        if (false !== $closedResource) {
            \fclose($closedResource);
        }
        $values[] = new ImmutableOpenResourceTestValueObject('file', $openFile);
        $values[] = new ImmutableOpenResourceTestValueObject('memory', $openResource);
        $values[] = new ImmutableClosedResourceTestValueObject('file', $closedFile);
        $values[] = new ImmutableClosedResourceTestValueObject('memory', $closedResource);

        // STRING
        $values[] = new ImmutableStringTestValueObject('empty', '');
        $values[] = new ImmutableStringTestValueObject('simple', 'abc');
        $values[] = new ImmutableStringTestValueObject('long', \str_repeat('long string-', 100));
        $values[] = new ImmutableStringTestValueObject('with trailing dot', 'a.');
        $values[] = new ImmutableStringTestValueObject('with dot in between', 'a.b');
        $values[] = new ImmutableStringTestValueObject('with leading dot', '.b');
        $values[] = new ImmutableStringTestValueObject('all chars', self::ALL_CHARS);
        $values[] = new ImmutableStringTestValueObject('global class string', \stdClass::class);
        $values[] = new ImmutableStringTestValueObject('class string', __CLASS__);
        $values[] = new ImmutableStringTestValueObject('file string', __FILE__);
        $values[] = new ImmutableStringTestValueObject('directory string', __DIR__);
        $values[] = new ImmutableStringTestValueObject('Domain', 'example.org');
        $values[] = new ImmutableStringTestValueObject('Hostname (FQDN)', 'www.example.org');
        $values[] = new ImmutableStringTestValueObject('hostname', 'www');
        $values[] = new ImmutableStringTestValueObject('URL', 'https://www.example.org/');
        $values[] = new ImmutableStringTestValueObject('URL with Path', 'https://www.example.org/path/');
        $values[] = new ImmutableStringTestValueObject('Email #1', 'user@example.org');
        $values[] = new ImmutableStringTestValueObject('Email #2', 'first.last@example.org');
        $values[] = new ImmutableStringTestValueObject('upper string', 'ABC');
        $values[] = new ImmutableStringTestValueObject('lower string', 'abc');
        $values[] = new ImmutableStringTestValueObject('capital letter', 'A');
        $values[] = new ImmutableStringTestValueObject('lower letter', 'a');
        $values[] = new ImmutableStringTestValueObject('digit', '1');
        $values[] = new ImmutableStringTestValueObject('digit', '-1');
        $values[] = new ImmutableStringTestValueObject('digit', '0');
        $values[] = new ImmutableStringTestValueObject('digit', '0.0');
        $values[] = new ImmutableStringTestValueObject('digit', '1.0');
        $values[] = new ImmutableStringTestValueObject('digit', '-1.0');
        $values[] = new ImmutableStringTestValueObject('digit', '1.2');
        $values[] = new ImmutableStringTestValueObject('digit', '-1.2');

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,array<array-key,mixed>> $result */
        $result = $this->get(TagEnum::ARRAY, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        $filter = new Filter($includeTags, $excludeTags);
        $allValues = $this->getValueObjects($includeTags, $excludeTags);
        foreach ($allValues as $value) {
            assert($value instanceof ImmutableSingleTestValueObjectInterface);
            $tags = $value->getTags();
            foreach ($tags->cases() as $tag) {
                if ($filter->isIncluded($tag)) {
                    try {
                        $val = $value->getValueByTag($tag);
                        $name = \mb_strtolower($tag->name);
                        $title = $value->getTitle();
                        $key = ($name === $title) ? $name : $name.' of '.$title;
                        yield $key => $val;
                    } catch (\Throwable) {
                        // we are not allowed to throw a within a Generator.
                    }
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getValueObjects(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        $filter = new Filter($includeTags, $excludeTags);
        foreach ($this->values as $key => $value) {
            $tags = $value->getTags();
            foreach ($tags->cases() as $tag) {
                if ($filter->isIncluded($tag)) {
                    yield $key => $value;
                    break;
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,bool> $result */
        $result = $this->get(TagEnum::BOOLEAN, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function empties(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        return $this->get([TagEnum::EMPTY], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function enums(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,\UnitEnum> $result */
        $result = $this->get(TagEnum::ENUM, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function floats(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,float> $result */
        $result = $this->get(TagEnum::FLOAT, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,mixed> $result */
        $result = $this->get(null, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function integers(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,int> $result */
        $result = $this->get(TagEnum::INTEGER, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,non-empty-string> $result */
        $result = $this->get(TagEnum::IP_ADDRESS, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,non-empty-string> $result */
        $result = $this->get(TagEnum::IPv4, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,non-empty-string> $result */
        $result = $this->get(TagEnum::IPv6, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function nulls(): \Generator
    {
        /** @var \Generator<non-empty-string,null> $result */
        $result = $this->get(TagEnum::NULL);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function objects(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,object> $result */
        $result = $this->get(TagEnum::OBJECT, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function resources(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,resource> $result */
        $result = $this->get(TagEnum::RESOURCE, $excludeTags);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function strings(TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        /** @var \Generator<non-empty-string,string> $result */
        $result = $this->get(TagEnum::STRING, $excludeTags);

        return $result;
    }
}
