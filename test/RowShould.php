<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;

class RowShould extends TestCase
{
    /**
     * @test
     * @dataProvider arrayProvider
     */
    public function know_if_it_has_repeated_numbers(array $array, bool $expectedResult): void
    {
        $row = new Row($array);

        $this->assertEquals($expectedResult, $row->hasRepeatedNumber());
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
}
