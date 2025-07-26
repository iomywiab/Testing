<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ExampleTest.php
 * Project: Testing
 * Modified at: 23/07/2025, 21:21
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Example;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Iomywiab\Library\Testing\Logging\Logger4Testing;
use Iomywiab\Library\Testing\Values\DataProvider;
use Iomywiab\Library\Testing\Values\Enums\SubstitutionEnum;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExampleClass::class)]
#[UsesClass(Format4Testing::class), UsesClass(Logger4Testing::class)]
class ExampleTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function provideTestData(): array
    {
        // Create a PHPUnit compatible parameter list
        $template = ['someBoolean' => true, 'key' => SubstitutionEnum::KEY, 'value' => SubstitutionEnum::VALUE];

        // We want to use UnitEnums ...
        $includeTags = [TagEnum::ENUM];

        // but we do not want to use BackedEnums
        $excludeTags = [TagEnum::ENUM_INT, TagEnum::ENUM_STRING];

        // Create an array with test values
        return DataProvider::byTemplate($template, $includeTags, $excludeTags);
    }

    /**
     * @param bool $someBoolean
     * @param non-empty-string $key
     * @param mixed $value
     * @return void
     * @throws \JsonException
     * @dataProvider provideTestData
     */
    public function testExample(bool $someBoolean, string $key, mixed $value): void
    {
        // Create a logger. This one is compatible with Psr\Log\LoggerInterface and therefore exchangeable
        $logger = new Logger4Testing();

        // Create a class and inject logger to that class
        $printer = new ExampleClass($logger);

        $this->expectOutputRegex('/.*/');
        $printer->echoValue($key, $value);

        self::assertTrue($someBoolean);
    }
}
