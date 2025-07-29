<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ImmutableTestValues.php
 * Project: Testing
 * Modified at: 29/07/2025, 21:03
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
use Iomywiab\Library\Testing\Values\Types\ImmutableSingleTestValueInterface;
use Iomywiab\Library\Testing\Values\Types\ImmutableStringTestValue;

class ImmutableTestValues implements ImmutableTestValuesInterface
{
    /** @noinspection SpellCheckingInspection */
    private const ALL_CHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    ."^°!\"§$%&/()[]{}=?`´äÄöÖüÜ+*#',;.:-_\\\t|~@\n\r";

    private const TEST_FILE = __DIR__.'/../Fixtures/TestValuesFile.txt';
    /** @var array<non-empty-string,array<non-empty-string,ImmutableSingleTestValueInterface>> $cachedObjects */
    private array $cachedObjects = [];
    /** @var array<non-empty-string,array<non-empty-string,mixed>> $cachedValues */
    private array $cachedValues = [];
    /** @var array<non-empty-string,ImmutableSingleTestValueInterface> $values */
    private array $values = [];

    /**
     * @inheritDoc
     */
    public function arrays(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get(TagEnum::ARRAY, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function get(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        $filter = new Filter($includeTags, $excludeTags);
        $key = $filter->getCacheKey();

        if (isset($this->cachedValues[$key])) {
            return $this->cachedValues[$key];
        }

        $values = [];
        $allValues = $this->getValues($includeTags, $excludeTags);
        foreach ($allValues as $value) {
            $tags = $value->getTags();
            foreach ($tags->cases() as $tag) {
                if ($filter->isIncluded($tag)) {
                    $val = $value->getValueByTag($tag);
                    $name = \mb_strtolower($tag->name);
                    $title = $value->getTitle();
                    $key = ($name === $title) ? $name : $name.' of '.$title;
                    \assert(!\array_key_exists($key, $values), '['.$key.'] already exists');
                    $values[$key] = $val;
                }
            }
        }

        $this->cachedValues[$key] = $values;

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function getValues(TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        $filter = new Filter($includeTags, $excludeTags);
        $cacheKey = $filter->getCacheKey();

        if (isset($this->cachedObjects[$cacheKey])) {
            return $this->cachedObjects[$cacheKey];
        }

        if ([] === $this->values) {
            $list = $this->getTestValuesList();
            foreach ($list as $item) {
                $key = $item->getTitle();
                $this->values[$key] = $item;
            }
        }
        \assert([] !== $this->values);

        $values = [];
        foreach ($this->values as $key => $value) {
            $tags = $value->getTags();
            foreach ($tags->cases() as $tag) {
                if ($filter->isIncluded($tag)) {
                    $values[$key] = $value;
                    break;
                }
            }
        }

        $this->cachedObjects[$cacheKey] = $values;

        return $values;
    }

    /**
     * @return list<ImmutableSingleTestValueInterface>
     * @throws TestValueExceptionInterface
     * @throws \Exception
     * @noinspection SpellCheckingInspection
     */
    private function getTestValuesList(): array
    {
        /** @var list<ImmutableSingleTestValueInterface> $values */
        $values = [];

        // ARRAY
        $values[] = new ImmutableArrayTestValue('empty', []);
        $values[] = new ImmutableArrayTestValue('non-empty-list', [1, 2]);
        $values[] = new ImmutableArrayTestValue('non-empty-array', [1 => 1, 2 => 2]);

        // BOOLEAN
        $values[] = new ImmutableBooleanTestValue(null, true);
        $values[] = new ImmutableBooleanTestValue(null, false);

        // BOOL STRING
        $values[] = new ImmutableBoolStringTestValue(null, 'true', true);
        $values[] = new ImmutableBoolStringTestValue(null, '1', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'activated', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'active', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'enabled', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'on', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'yes', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'y', true);
        $values[] = new ImmutableBoolStringTestValue(null, 'false', false);
        $values[] = new ImmutableBoolStringTestValue(null, '0', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'deactivated', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'inactive', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'disabled', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'off', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'no', false);
        $values[] = new ImmutableBoolStringTestValue(null, 'n', false);

        // CHAR
        $length = \mb_strlen(self::ALL_CHARS);
        for ($i = 0; $i < $length; $i++) {
            $char = \mb_substr(self::ALL_CHARS, $i, 1);
            $values[] = new ImmutableCharTestValue(null, $char);
        }

        // DATETIME
        $tz = new \DateTimeZone('UTC');
        $values[] = new ImmutableDateTimeTestValue('first unix timestamp', '1970-01-01 00:00:00');
        $values[] = new ImmutableDateTimeTestValue('before 2000', '1999-12-31 23:59:59');
        $values[] = new ImmutableDateTimeTestValue('start of year 2000', '2000-01-01 00:00:00');
        $values[] = new ImmutableDateTimeTestValue('random date', '2020-01-02 03:04:05');
        $values[] = new ImmutableDateTimeTestValue('last unix timestamp', '2038-01-19 03:14:06');
        $values[] = new ImmutableDateTimeTestValue('now', 'now');
        $values[] = new ImmutableDateTimeTestValue('datetime object', new \DateTime('2000-01-01 00:00:00', $tz));

        // ENUM
        $values[] = new ImmutableObjectTestValue('UnitEnum', Enum4Testing::ONE);
        $values[] = new ImmutableObjectTestValue('IntBackedEnum', IntEnum4Testing::ONE);
        $values[] = new ImmutableObjectTestValue('StringIntEnum', StringEnum4Testing::ONE);

        // EXCEPTION
        $values[] = new ImmutableObjectTestValue('Exception', new \Exception());
        $values[] = new ImmutableObjectTestValue('RuntimeException', new \RuntimeException());
        $values[] = new ImmutableObjectTestValue('LogicException', new \LogicException());

        // FLOAT
        $values[] = new ImmutableFloatTestValue('-PHP_FLOAT_MAX', -PHP_FLOAT_MAX);
        $values[] = new ImmutableFloatTestValue('PHP_FLOAT_MIN', PHP_FLOAT_MIN);
        $values[] = new ImmutableFloatTestValue('PHP_FLOAT_MAX', PHP_FLOAT_MAX);
        $values[] = new ImmutableFloatTestValue(null, -1234567890.123456789);
        $values[] = new ImmutableFloatTestValue(null, 1234567890.123456789);
        $values[] = new ImmutableFloatTestValue(null, -9.123456789);
        $values[] = new ImmutableFloatTestValue(null, 9.123456789);
        $values[] = new ImmutableFloatTestValue(null, -1.2);
        $values[] = new ImmutableFloatTestValue(null, 1.2);
        $values[] = new ImmutableFloatTestValue(null, -0.1);
        $values[] = new ImmutableFloatTestValue(null, 0.1);
        $values[] = new ImmutableFloatTestValue(null, -1234567890.0);
        $values[] = new ImmutableFloatTestValue(null, 1234567890.0);
        $values[] = new ImmutableFloatTestValue(null, -7.0);
        $values[] = new ImmutableFloatTestValue(null, 7.0);
        $values[] = new ImmutableFloatTestValue(null, -1.0);
        $values[] = new ImmutableFloatTestValue(null, 1.0);
        $values[] = new ImmutableFloatTestValue(null, 0.0);

        // INTEGER
        $values[] = new ImmutableIntegerTestValue('PHP_INT_MIN', PHP_INT_MIN);
        $values[] = new ImmutableIntegerTestValue('min signed 4 byte - 1', -2147483649);
        $values[] = new ImmutableIntegerTestValue('min signed 4 byte', -2147483648);
        $values[] = new ImmutableIntegerTestValue('min signed 2 byte - 1', -32769);
        $values[] = new ImmutableIntegerTestValue('min signed 2 byte', -32768);
        $values[] = new ImmutableIntegerTestValue('min signed 1 byte - 1', -128);
        $values[] = new ImmutableIntegerTestValue('greatest int less than 0', -1);
        $values[] = new ImmutableIntegerTestValue('min unsigned', 0);
        $values[] = new ImmutableIntegerTestValue('smallest int greater than 0', 1);
        $values[] = new ImmutableIntegerTestValue('max unsigned 1 byte', 255);
        $values[] = new ImmutableIntegerTestValue('max unsigned 1 byte + 1', 256);
        $values[] = new ImmutableIntegerTestValue('max signed 2 byte', 32767);
        $values[] = new ImmutableIntegerTestValue('max signed 2 byte + 1', 32768);
        $values[] = new ImmutableIntegerTestValue('max unsigned 2 byte', 65535);
        $values[] = new ImmutableIntegerTestValue('max unsigned 2 byte + 1', 65536);
        $values[] = new ImmutableIntegerTestValue('max signed 4 byte + 1', 2147483648);
        $values[] = new ImmutableIntegerTestValue('max unsigned 4 byte', 4294967295);
        $values[] = new ImmutableIntegerTestValue('max unsigned 4 byte + 1', 4294967296);
        $values[] = new ImmutableIntegerTestValue('max signed 4 byte', 9223372036854775807);
        //$values[]=new ImmutableIntegerTestValue('max signed 4 byte + 1', (int)9223372036854775808); // would cause overflow
        $values[] = new ImmutableIntegerTestValue('PHP_INT_MAX', PHP_INT_MAX);

        // IPv4
        $values[] = new ImmutableIpv4TestValue('all', '0.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class A public: begin', '1.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class A public: end', '127.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class A private: start', '10.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class A private: end', '10.255.255.255');
        $values[] = new ImmutableIpv4TestValue('class A subnet mask', '255.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class B public: begin', '128.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class B public: end', '191.255.0.0');
        $values[] = new ImmutableIpv4TestValue('class B private: begin', '172.16.0.0');
        $values[] = new ImmutableIpv4TestValue('class B private: end', '172.31.255.255');
        $values[] = new ImmutableIpv4TestValue('class B subnet mask', '255.255.0.0');
        /** @noinspection SpellCheckingInspection */
        $values[] = new ImmutableIpv4TestValue('class B private APIPA: begin', '169.254.0.0');
        /** @noinspection SpellCheckingInspection */
        $values[] = new ImmutableIpv4TestValue('class B private APIPA: end', '169.254.255.255');
        $values[] = new ImmutableIpv4TestValue('class C public: begin', '192.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class C public: end', '223.255.255.0');
        $values[] = new ImmutableIpv4TestValue('class C private: begin', '192.168.0.0');
        $values[] = new ImmutableIpv4TestValue('class C private: end', '192.168.255.255');
        $values[] = new ImmutableIpv4TestValue('class C subnet mask', '255.255.255.0');
        $values[] = new ImmutableIpv4TestValue('class D: begin', '224.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class D: end', '239.255.255.255');
        $values[] = new ImmutableIpv4TestValue('class E: begin', '240.0.0.0');
        $values[] = new ImmutableIpv4TestValue('class E: end', '255.255.255.255');
        $values[] = new ImmutableIpv4TestValue('broadcast', '255.255.255.255');
        $values[] = new ImmutableIpv4TestValue('Google DNS resolver', '8.8.8.8');

        // IPv6
        $values[] = new ImmutableIpv6TestValue('Loopback', '::1');
        //$values[] = new ImmutableIpv6TestValue('Link-Local', 'fe80::/10');
        //$values[] = new ImmutableIpv6TestValue('Unique Local', 'fc99::/7');
        //$values[] = new ImmutableIpv6TestValue('Global unicast', '2000::/3');
        //$values[] = new ImmutableIpv6TestValue('Multicast', 'ff00::/8');
        //$values[] = new ImmutableIpv6TestValue('Documentation', '2001:db8::/32');
        //$values[] = new ImmutableIpv6TestValue('IPv4-mapped #1', '::ffff:0:0/96');
        $values[] = new ImmutableIpv6TestValue('IPv4-mapped #2', '::ffff:192.168.1.1');
        $values[] = new ImmutableIpv6TestValue(null, '2001:0db8:85a3:08d3:1319:8a2e:0370:7334');

        // MAC
        $values[] = new ImmutableStringTestValue('MAC#1', '00:1A:2B:3C:4D:5E');
        $values[] = new ImmutableStringTestValue('MAC#2', '00-1A-2B-3C-4D-5E');
        $values[] = new ImmutableStringTestValue('MAC#3', 'AB:CD:EF:12:34:56:78');

        // NULL
        $values[] = new ImmutableNullTestValue(null, null);

        // OBJECT
        $values[] = new ImmutableObjectTestValue('stdClass', new \stdClass);

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
        $values[] = new ImmutableOpenResourceTestValue('file', $openFile);
        $values[] = new ImmutableOpenResourceTestValue('memory', $openResource);
        $values[] = new ImmutableClosedResourceTestValue('file', $closedFile);
        $values[] = new ImmutableClosedResourceTestValue('memory', $closedResource);

        // STRING
        $values[] = new ImmutableStringTestValue('empty', '');
        $values[] = new ImmutableStringTestValue('simple', 'abc');
        $values[] = new ImmutableStringTestValue('long', \str_repeat('long string-', 100));
        $values[] = new ImmutableStringTestValue('with trailing dot', 'a.');
        $values[] = new ImmutableStringTestValue('with dot in between', 'a.b');
        $values[] = new ImmutableStringTestValue('with leading dot', '.b');
        $values[] = new ImmutableStringTestValue('all chars', self::ALL_CHARS);
        $values[] = new ImmutableStringTestValue('global class string', \stdClass::class);
        $values[] = new ImmutableStringTestValue('class string', __CLASS__);
        $values[] = new ImmutableStringTestValue('file string', __FILE__);
        $values[] = new ImmutableStringTestValue('directory string', __DIR__);
        $values[] = new ImmutableStringTestValue('Domain', 'example.org');
        $values[] = new ImmutableStringTestValue('Hostname (FQDN)', 'www.example.org');
        $values[] = new ImmutableStringTestValue('hostname', 'www');
        $values[] = new ImmutableStringTestValue('URL', 'https://www.example.org/');
        $values[] = new ImmutableStringTestValue('URL with Path', 'https://www.example.org/path/');
        $values[] = new ImmutableStringTestValue('Email #1', 'user@example.org');
        $values[] = new ImmutableStringTestValue('Email #2', 'first.last@example.org');
        $values[] = new ImmutableStringTestValue('upper string', 'ABC');
        $values[] = new ImmutableStringTestValue('lower string', 'abc');
        $values[] = new ImmutableStringTestValue('capital letter', 'A');
        $values[] = new ImmutableStringTestValue('lower letter', 'a');
        $values[] = new ImmutableStringTestValue('digit', '1');
        $values[] = new ImmutableStringTestValue('digit', '-1');
        $values[] = new ImmutableStringTestValue('digit', '0');
        $values[] = new ImmutableStringTestValue('digit', '0.0');
        $values[] = new ImmutableStringTestValue('digit', '1.0');
        $values[] = new ImmutableStringTestValue('digit', '-1.0');
        $values[] = new ImmutableStringTestValue('digit', '1.2');
        $values[] = new ImmutableStringTestValue('digit', '-1.2');

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function booleans(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::BOOLEAN], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function empties(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::EMPTY], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function enums(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::ENUM], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function floats(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::FLOAT], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function getWithout(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get(null, $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function integers(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::INTEGER], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function ipAddresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::IP_ADDRESS], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function ipv4Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::IPv4], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function ipv6Addresses(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::IPv6], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function nulls(): array
    {
        return $this->get([TagEnum::NULL]);
    }

    /**
     * @inheritDoc
     */
    public function objects(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::OBJECT], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function resources(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::RESOURCE], $excludeTags);
    }

    /**
     * @inheritDoc
     */
    public function strings(TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        return $this->get([TagEnum::STRING], $excludeTags);
    }
}
