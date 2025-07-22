<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: Logger4Testing.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Logging;

use Iomywiab\Library\Testing\Formatting\Format4Testing;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger4Testing implements LoggerInterface
{
    private const DEFAULT_ENABLED = true;

    use LoggerTrait;

    /**
     * @param bool|null $enabled
     */
    public function __construct(private readonly ?bool $enabled = null)
    {
        // no code
    }

    /**
     * @param mixed $level
     * @param string|\Stringable $message
     * @param array<array-key,mixed> $context
     * @return non-empty-string
     * @noinspection PhpMultipleClassDeclarationsInspection
     */
    public function makeMessage(mixed $level, string|\Stringable $message, array $context): string
    {
        $lev = \is_scalar($level) ? $level : \gettype($level);
        $msg = (string)$message;

        if ([] === $context) {
            return "[$lev] $msg";
        }

        $replace = [];
        foreach ($context as $key => $val) {
            try {
                $replacement = Format4Testing::toString($val);
            } catch (\Throwable $cause) {
                $replacement = $cause->getMessage();
            }
            $replace['{'.$key.'}'] = $replacement;
        }

        return "[$lev] ".\strtr($msg, $replace);
    }

    /**
     * @param mixed $level
     * @param string|\Stringable $message
     * @param array<array-key,mixed> $context
     * @return void
     * @noinspection PhpMultipleClassDeclarationsInspection
     */
    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        if ($this->enabled ?? self::DEFAULT_ENABLED) {
            echo $this->makeMessage($level, $message, $context).PHP_EOL;
        }
    }
}
