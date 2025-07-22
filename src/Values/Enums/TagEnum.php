<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TagEnum.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Enums;

/**
 * Attention! Integer value must be a value with only a single bit set
 */
enum TagEnum: int
{
    case ARRAY = 1; // PHP \gettype()
    case BOOLEAN = 1 << 1; // PHP \gettype()
    case BOOL_STRING = 1 << 2;
    case CAPITAL_LETTER = 1 << 3;
    case CHAR = 1 << 4;
    case CLOSED_RESOURCE = 1 << 5; // PHP \gettype()
    case DATETIME = 1 << 6;
    case DIGIT = 1 << 7;
    case DOMAIN = 1 << 8;
    case EMAIL = 1 << 9;
    case EMPTY = 1 << 10;
    case ENUM = 1 << 11;
    case ENUM_INT = 1 << 12;
    case ENUM_STRING = 1 << 13;
    case EXCEPTION = 1 << 14;
    case FLOAT = 1 << 15; // PHP \gettype()
    case FLOAT_NEGATIVE = 1 << 16;
    case FLOAT_NOT_NEGATIVE = 1 << 17;
    case FLOAT_POSITIVE = 1 << 18;
    case FLOAT_WITH_INT_VALUE = 1 << 19;
    case INTEGER = 1 << 20; // PHP \gettype()
    case INTEGER_NEGATIVE = 1 << 21;
    case INTEGER_NOT_NEGATIVE = 1 << 22;
    case INTEGER_POSITIVE = 1 << 23;
    case IP_ADDRESS = 1 << 24;
    case IPv4 = 1 << 25;
    case IPv6 = 1 << 26;
    case LETTER = 1 << 27;
    case MAC = 1 << 28;
    case NULL = 1 << 29; // PHP \gettype()
    case OBJECT = 1 << 30; // PHP \gettype()
    case PRIME = 1 << 31;
    case RESOURCE = 1 << 32; // PHP \gettype()
    case SMALL_LETTER = 1 << 33;
    case STRING = 1 << 34; // PHP \gettype()
    case STRING_FLOAT = 1 << 35;
    case STRING_INTEGER = 1 << 36;
    case STRING_LOWER = 1 << 37;
    case STRING_NUMERIC = 1 << 38;
    case STRING_UPPER = 1 << 39;
    case URL = 1 << 40;

    /**
     * @param mixed $data
     * @return self
     */
    public static function fromData(mixed $data): self
    {
        $type = \gettype($data);

        /** @noinspection PhpDuplicateMatchArmBodyInspection */
        return match ($type) {
            'array' => self::ARRAY,
            'boolean' => self::BOOLEAN,
            'double' => self::FLOAT,
            'integer' => self::INTEGER,
            'NULL' => self::NULL,
            'object' => self::OBJECT,
            'resource' => self::RESOURCE,
            'resource (closed)' => self::CLOSED_RESOURCE,
            'string' => self::STRING,
            'unknown type' => self::NULL,
        };
    }

    /**
     * @param int $number
     * @return bool
     */
    private function isPrimeTrialDivision(int $number): bool
    {
        if ($number <= 1) {
            return false;
        }
        if ($number <= 3) {
            return true;
        }
        if ((($number % 2) === 0) || (($number % 3) === 0)) {
            return false;
        }

        for ($i = 5; ($i * $i) <= $number; $i += 6) {
            if ((($number % $i) === 0) || (($number % ($i + 2)) === 0)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isMine(mixed $value): bool
    {
        return match ($this) {
            self::ARRAY => \is_array($value),
            self::BOOLEAN => \is_bool($value),
            self::BOOL_STRING => (\is_string($value) && \in_array(\mb_strtolower($value), ['true', 'false'], true)),
            self::CAPITAL_LETTER => \is_string($value) && (1 === \mb_strlen($value)) && \ctype_upper($value),
            self::CHAR => \is_string($value) && (1 === \mb_strlen($value)),
            self::CLOSED_RESOURCE => false, // cannot be determined
            self::DATETIME => ($value instanceof \DateTimeInterface),
            self::DIGIT => \is_string($value) && (1 === \mb_strlen($value)) && \ctype_digit($value),
            self::DOMAIN => \is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME),
            self::EMAIL => \is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_EMAIL),
            self::EMPTY => empty($value),
            self::ENUM => ($value instanceof \UnitEnum),
            self::ENUM_INT => ($value instanceof \BackedEnum) && \is_int($value->value),
            self::ENUM_STRING => ($value instanceof \BackedEnum) && \is_string($value->value),
            self::EXCEPTION => ($value instanceof \Throwable),
            self::FLOAT => \is_float($value),
            self::FLOAT_NEGATIVE => \is_float($value) && ($value < 0.0),
            self::FLOAT_NOT_NEGATIVE => ($value === 0.0),
            self::FLOAT_POSITIVE => \is_float($value) && ($value > 0.0),
            self::FLOAT_WITH_INT_VALUE => \is_float($value) && (\floor($value) === $value),
            self::INTEGER => \is_int($value),
            self::INTEGER_NEGATIVE => \is_int($value) && ($value < 0),
            self::INTEGER_NOT_NEGATIVE => ($value === 0),
            self::INTEGER_POSITIVE => \is_int($value) && ($value > 0),
            self::IP_ADDRESS => (\is_int($value)&&(0<$value)) || (\is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_IP)),
            self::IPv4 => (\is_int($value)&&(0<$value) && $value < (1 << 32)) || (\is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)),
            self::IPv6 => (\is_int($value)&&(0<$value)) || (\is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)),
            self::LETTER => \is_string($value) && (1 === \mb_strlen($value)) && \ctype_alpha($value),
            self::MAC => \is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_MAC),
            self::NULL => (null === $value),
            self::OBJECT => \is_object($value),
            self::PRIME => \is_int($value) && $this->isPrimeTrialDivision($value),
            self::RESOURCE => \is_resource($value),
            self::SMALL_LETTER => \is_string($value) && (1 === \mb_strlen($value)) && \ctype_lower($value),
            self::STRING => \is_string($value),
            self::STRING_FLOAT => \is_string($value) && \is_numeric($value) && (\str_contains($value, '.')),
            self::STRING_INTEGER => \is_string($value) && \is_numeric($value) && (\floor((float)$value) === (float)$value),
            self::STRING_LOWER => \is_string($value) && \ctype_lower($value),
            self::STRING_NUMERIC => \is_string($value) && \is_numeric($value),
            self::STRING_UPPER => \is_string($value) && \ctype_upper($value),
            self::URL => \is_string($value) && (bool)\filter_var($value, FILTER_VALIDATE_URL),
        };
    }
}
