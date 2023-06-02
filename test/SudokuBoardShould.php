<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;
use Sudoku\Exception\InvalidMatrix;
use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;
use Exception;

class SudokuBoardShould extends TestCase
{
    /**
     * @test
     * @dataProvider invalidMatricesProvider
     */
    public function should_not_accept_invalid_matrices(array $invalidMatrix): void
    {
        try {
            new SudokuBoard($invalidMatrix);
        } catch (Exception) {
            $this->expectNotToPerformAssertions();
            return ;
        }

        $this->fail();
    }

    /**
     * @test
     * @throws InvalidMatrix
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     * @dataProvider validMatrixProvider
     */
    public function should_accept_valid_matrices(): void
    {
        $this->expectNotToPerformAssertions();
        $validMatrix =
            [
                [1, 2, 3, 4,],
                [4, 3, 1, 2,],
                [3, 4, 2, 1,],
                [2, 1, 4, 3,],
            ];

        $board = new SudokuBoard($validMatrix);
    }

    public function accept_adding_numbers_on_empty_squares(SudokuBoard $initialBoard, int $row, int $col, int $value, SudokuBoard $finalBoard): void
    {
        $newBoard = $initialBoard->addNumber($row, $col, $value);
        $this->assertEquals($newBoard, $finalBoard);
    }

    /**
     * @test
     * @dataProvider completeMatricesProvider
     * @param array $matrix
     * @param bool $expectedResult
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix|InvalidMatrix
     */
    public function know_when_it_is_complete(array $matrix, bool $expectedResult): void
    {
        $sudokuBoard = new SudokuBoard($matrix);
        $this->assertEquals($expectedResult, $sudokuBoard->isComplete());
    }

    public function completeMatricesProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 3, 4,],
                        [4, 3, 2, 1,],
                        [3, 1, 4, 2,],
                        [2, 4, 1, 3,],
                    ],
                    true,
                ],
                [
                    [
                        [1, 2, 3, 4,],
                        [4, 3, 2, 0,],
                        [0, 0, 0, 1,],
                        [3, 0, 0, 2,],
                    ],
                    false,
                ],
            ];
    }

    public function validMatrixProvider(): array
    {
        return
            [
                [
                    [
                        [1, 2, 3, 4,],
                        [4, 3, 1, 2,],
                        [3, 4, 2, 1,],
                        [2, 1, 4, 3,],
                    ],
                ],
                [
                    [
                        [1, 2, 3, 4,],
                        [4, 0, 1, 2,],
                        [3, 4, 2, 1,],
                        [2, 0, 0, 3,],
                    ],
                ],
            ];
    }

    public function invalidMatricesProvider(): array
    {
        return
        [
            [$this->buildMatrixWithRepeatedNumberInColumn(),],
            [$this->buildMatrixWithRepeatedNumberInRow(),],
            [$this->buildMatrixWithRepeatedNumberInQuadrant(),],
        ];
    }

    /**
     * @return array[]
     */
    protected function buildMatrixWithRepeatedNumberInColumn(): array
    {
        return [
            [1, 2, 3, 7,],
            [1, 5, 6, 8,],
            [2, 3, 4, 1,],
            [7, 8, 9, 1,],
        ];
    }

    private function buildMatrixWithRepeatedNumberInRow(): array
    {
        return [
            [1, 0, 1, 3,],
            [2, 4, 3, 0,],
            [3, 1, 4, 0,],
            [4, 0, 2, 1,],
        ];
    }

    private function buildMatrixWithRepeatedNumberInQuadrant(): array
    {
        return [
            [1, 2, 4, 3,],
            [2, 4, 0, 0,],
            [3, 1, 0, 0,],
            [4, 0, 2, 1,],
        ];
    }
}
