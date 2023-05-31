<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;

class NumberSetShould extends TestCase
{
    /**
     * @test
     * @dataProvider arrayProvider
     */
    public function know_if_it_has_repeated_numbers(array $array, bool $expectedResult): void
    {
        $row = new NumberSet($array);

        $this->assertEquals($expectedResult, $row->hasRepeatedNumber());
    }

    /**
     * @test
     * @dataProvider diffProvider
     */
    public function calculate_its_difference_with_other_sets(NumberSet $initialSet, array $otherSets, NumberSet $result): void
    {
        $this->assertEquals($initialSet->diff(...$otherSets), $result);
    }

    public function arrayProvider(): array
    {
        return
            [
                [
                    [1, 2, 2, 5,], true,
                ],
                [
                    [1, 2, 3, 5,], false,
                ],
            ];
    }

    public function diffProvider(): array
    {
        return
            [
                [
                    new NumberSet([1, 2, 3, 5,]), [ new NumberSet([]), ], new NumberSet([1, 2, 3, 5,]),
                ],
            ];
    }
}
