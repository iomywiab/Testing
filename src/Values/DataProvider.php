<?php
/*
 * Copyright (c) 2022-2025 Iomywiab/PN, Hamburg, Germany. All rights reserved
 * File name: DataProvider.php
 * Project: Testing
 * Modified at: 23/07/2025, 21:19
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
     * @param non-empty-array<array-key,mixed> $template
     * @param TagsInterface|list<TagEnum>|TagEnum|null $includeTags
     * @param TagsInterface|list<TagEnum>|TagEnum|null $excludeTags
     * @return non-empty-array<array-key,mixed>
     * @throws TestValueExceptionInterface
     */
    public static function byTemplate(array $template, TagsInterface|array|TagEnum|null $includeTags = null, TagsInterface|array|TagEnum|null $excludeTags = null): array
    {
        $testValues = TestValues::get($includeTags, $excludeTags);
        $return = [];
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
            $return[$testTitle] = $row;
        }

        return $return;
    }

    /**
     * @param array $keys
     * @param array $testValues
     * @return array
     */
    public static function injectKeys(array $keys, array $testValues): array
    {
        $size = \count($keys);
        $array = [];
        foreach ($testValues as $datasetKey => $dataset) {
            \assert(\is_array($dataset));
            \assert(\count($dataset) === $size);
            $index = 0;
            $newDataset = [];
            foreach ($dataset as $value) {
                $newDataset[$keys[$index]] = $value;
                $index++;
            }
            $array[$datasetKey] = $newDataset;
        }

        return $array;
    }
}
