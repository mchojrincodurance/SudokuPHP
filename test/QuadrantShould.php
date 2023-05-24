<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;
use Sudoku\Exception\NonSquareMatrix;

class QuadrantShould extends TestCase
{
    /**
     * @test
     * @dataProvider arrayProvider
     * @throws NonSquareMatrix
     */
    public function know_if_it_has_repeated_numbers(array $matrix, bool $expectedResult): void
    {
        $row = new Quadrant($matrix);

        $this->assertEquals($expectedResult, $row->hasRepeatedNumber());
    }

    public function arrayProvider(): array
    {
        return
            [
                [
                    [[1, 2,],[2, 5,]], true,
                ],
                [
                    [[1, 2,],[3, 5,]], false,
                ],
            ];
    }
}
