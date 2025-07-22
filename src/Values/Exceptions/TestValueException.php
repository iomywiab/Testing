<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValueException.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Exceptions;

/**
 * TestValueException
 */
class TestValueException extends \RuntimeException implements TestValueExceptionInterface
{
    /**
     * @param string          $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
