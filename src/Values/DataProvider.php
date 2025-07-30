<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DataProvider.php
 * Project: Testing
 * Modified at: 30/07/2025, 10:33
 * Modified by: pnehls
 */

declare(strict_types=1);

namespace Iomywiab\Library\Testing\Values;

use Iomywiab\Library\Testing\Values\Enums\SubstitutionEnum;
use Iomywiab\Library\Testing\Values\Enums\TagEnum;
use Iomywiab\Library\Testing\Values\Exceptions\TestValueExceptionInterface;
use Iomywiab\Library\Testing\Values\Tags\TagsInterface;

class DataProvider
{

    /**
     * @param non-empty-array<non-empty-string,mixed> $template
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return \Generator<non-empty-string,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function byTemplate(array $template, TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): \Generator
    {
        $testValues = TestValues::get($includeTags, $excludeTags);
        foreach ($testValues as $testTitle => $testValue) {
            $row = $template;
            foreach ($row as $key => $value) {
                switch ($value) {
                    case SubstitutionEnum::KEY:
                        $row[$key] = $testTitle;
                        break;
                    case SubstitutionEnum::VALUE:
                        $row[$key] = $testValue;
                        break;
                }
            }
            yield $testTitle => $row;
        }
    }

    /**
     * @param non-empty-array<array-key,non-empty-string> $keys
     * @param non-empty-array<array-key,non-empty-array<array-key,mixed>> $testValues
     * @return \Generator<array-key,non-empty-array<array-key,mixed>>
     */
    public static function injectKeys(array $keys, array $testValues): \Generator
    {
        $size = \count($keys);
        foreach ($testValues as $datasetKey => $dataset) {
            \assert(\is_array($dataset));
            \assert(\count($dataset) === $size);
            $index = 0;
            $newDataset = [];
            foreach ($dataset as $value) {
                $newDataset[$keys[$index]] = $value;
                $index++;
            }
            yield $datasetKey => $newDataset;
        }
    }
}
