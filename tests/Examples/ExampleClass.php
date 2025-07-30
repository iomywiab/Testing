<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: ExampleClass.php
 * Project: Testing
 * Modified at: 29/07/2025, 23:50
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Examples;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Psr\Log\LoggerInterface;

class ExampleClass
{
    /**
     * @param LoggerInterface|null $logger
     */
    public function __construct(private readonly ?LoggerInterface $logger = null)
    {
        // no code
    }

    /**
     * @param non-empty-string $key
     * @param mixed $value
     * @return void
     * @throws \JsonException
     */
    public function echoValue(string $key, mixed $value): void
    {
        // use injected logger
        $this->logger?->debug('Example is printing. key={k} value={v}', ['k' => $key, 'v' => $value]);

        // format the value and print a line
        echo 'key='.$key.' value='.\gettype($value).':'.Format4Testing::toString($value).PHP_EOL;
    }
}
