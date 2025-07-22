<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: LoggerForTestingTest.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:26
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Tests\Testing\Unit\Logging;

use Iomywiab\Library\Testing\Logging\Logger4Testing;
use PHPUnit\Framework\TestCase;

class LoggerForTestingTest extends TestCase
{
    /**
     * @return void
     */
    public function testLogger(): void
    {
        $logger = new Logger4Testing(true);

        \ob_start();

        $logger->log('debug', 'value {a}', ['a' => 'b']);
        $logger->emergency('value {a}', ['a' => 'b']);
        $logger->alert('value {a}', ['a' => 'b']);
        $logger->critical('value {a}', ['a' => 'b']);
        $logger->error('value {a}', ['a' => 'b']);
        $logger->warning('value {a}', ['a' => 'b']);
        $logger->notice('value {a}', ['a' => 'b']);
        $logger->info('value {a}', ['a' => 'b']);
        $logger->debug('value {a}');

        $output = \ob_get_clean();

        $eol = PHP_EOL;
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        self::assertSame(
            "[debug] value \"b\"{$eol}"
            . "[emergency] value \"b\"{$eol}"
            . "[alert] value \"b\"{$eol}"
            . "[critical] value \"b\"{$eol}"
            . "[error] value \"b\"{$eol}"
            . "[warning] value \"b\"{$eol}"
            . "[notice] value \"b\"{$eol}"
            . "[info] value \"b\"{$eol}"
            . "[debug] value {a}{$eol}",
            $output
        );

        $logger = new Logger4Testing(false);

        \ob_start();

        $logger->log('debug', 'value {a}', ['a' => 'b']);
        $logger->emergency('value {a}', ['a' => 'b']);
        $logger->alert('value {a}', ['a' => 'b']);
        $logger->critical('value {a}', ['a' => 'b']);
        $logger->error('value {a}', ['a' => 'b']);
        $logger->warning('value {a}', ['a' => 'b']);
        $logger->notice('value {a}', ['a' => 'b']);
        $logger->info('value {a}', ['a' => 'b']);
        $logger->debug('value {a}', ['a' => 'b']);

        $output = \ob_get_clean();

        self::assertSame('', $output);
    }
}
