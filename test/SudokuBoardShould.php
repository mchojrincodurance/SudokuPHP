<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;
use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;

class SudokuBoardShould extends TestCase
{
    /**
     * @test
     */
    public function should_not_accept_non_square_matrices(): void
    {
        $this->expectException(NonSquareMatrix::class);
        $nonSquareMatrix = [
            [1, 2, 3,],
            [4, 5, 6,],
        ];
        $sudokuBoard = new SudokuBoard($nonSquareMatrix);
    }

    /**
     * @test
     */
    public function should_accept_valid_matrices(): void
    {
        $validMatrix = [
            [1, 2, 3, 7,],
            [4, 5, 6, 8,],
            [7, 8, 9, 1,],
            [7, 8, 9, 1,],
        ];

        $this->assertNotEmpty(new SudokuBoard($validMatrix));
    }

    /**
     * @test
     */
    public function should_not_accept_tiny_matrices(): void
    {
        $this->expectException(TooSmallMatrix::class);
        $nonSquareMatrix = [
            [1, 2,],
            [4, 5,],
        ];
        $sudokuBoard = new SudokuBoard($nonSquareMatrix);
    }

    /**
     * @test
     * @dataProvider completeMatricesProvider
     * @param array $matrix
     * @param bool $expectedResult
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     */
    public function know_when_it_is_complete(array $matrix, bool $expectedResult): void
    {
        $sudokuBoard = new SudokuBoard($matrix);
        $this->assertEquals($expectedResult, $sudokuBoard->isComplete());
    }

    /**
     * @test
     * @dataProvider repeatedRowsMatricesProvider
     */
    public function should_know_when_it_has_repeated_numbers_in_any_row(array $matrix, bool $expectedResult): void
    {
        $sudokuBoard = new SudokuBoard($matrix);
        $this->assertEquals($expectedResult, $sudokuBoard->hasRepeatedNumberInAnyRow());
    }

    /**
     * @test
     * @dataProvider repeatedColumnsMatricesProvider
     */
    public function should_know_when_it_has_repeated_numbers_in_any_column(array $matrix, bool $expectedResult): void
    {
        $sudokuBoard = new SudokuBoard($matrix);
        $this->assertEquals($expectedResult, $sudokuBoard->hasRepeatedNumberInAnyColumn());
    }

    /**
     * @test
     * @dataProvider repeatedQuadrantsMatricesProvider
     */
    public function should_know_when_it_has_repeated_numbers_in_any_quadrant(array $matrix, bool $expectedResult): void
    {
        $sudokuBoard = new SudokuBoard($matrix);
        $this->assertEquals($expectedResult, $sudokuBoard->hasRepeatedNumberInAnyColumn());
    }

    public function completeMatricesProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 3, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 0, 1,],
                        [7, 8, 9, 1,],
                    ],
                    false,
                ],
            ];
    }

    public function repeatedRowsMatricesProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 7, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 6, 6, 8,],
                        [7, 7, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 7, 7, 7,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 0, 1,],
                        [7, 8, 9, 1,],
                    ],
                    false,
                ],
            ];
    }

    public function repeatedColumnsMatricesProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 3, 7,],
                        [1, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 8, 7,],
                        [4, 5, 6, 8,],
                        [6, 8, 7, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [7, 6, 6, 8,],
                        [7, 7, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 7, 7, 7,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [4, 5, 6, 8,],
                        [6, 8, 0, 1,],
                        [7, 1, 9, 2,],
                    ],
                    false,
                ],
            ];
    }

    public function repeatedQuadrantsMatricesProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 3, 7,],
                        [1, 5, 6, 8,],
                        [2, 3, 4, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 8, 7,],
                        [4, 5, 6, 8,],
                        [6, 8, 7, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [7, 6, 6, 8,],
                        [7, 7, 9, 1,],
                        [7, 8, 9, 1,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 1, 7,],
                        [4, 5, 6, 8,],
                        [7, 8, 9, 1,],
                        [7, 7, 7, 7,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 7,],
                        [4, 5, 6, 8,],
                        [6, 8, 0, 1,],
                        [7, 1, 9, 2,],
                    ],
                    false,
                ],
            ];
    }
}
