<?php

declare(strict_types=1);

namespace Sudoku;

use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;

class SolutionChecker
{
    /**
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     */
    public function compliesWithSudokuRules(array $matrix): bool
    {
        $sudokuBoard = new SudokuBoard($matrix);

        return $sudokuBoard->isComplete() &&
            !$sudokuBoard->hasRepeatedNumberInAnyRow() &&
            !$sudokuBoard->hasRepeatedNumberInAnyColumn() &&
            !$sudokuBoard->hasRepeatedNumberInAnyQuadrant();
    }
}