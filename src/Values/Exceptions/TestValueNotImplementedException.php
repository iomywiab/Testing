<?php

/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: TestValueNotImplementedException.php
 * Project: Testing
 * Modified at: 21/07/2025, 10:18
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values\Exceptions;

/**
 * TestValueException
 */
class TestValueNotImplementedException extends \RuntimeException implements TestValueExceptionInterface
{
    /**
     * @param non-empty-string $methodName
     * @param \Throwable|null $previous
     */
    public function __construct(string $methodName, ?\Throwable $previous = null)
    {
        parent::__construct('Not implemented. method="'.$methodName.'"', 0, $previous);
    }
}
