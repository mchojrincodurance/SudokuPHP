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

    /**
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     */
    public function isSolutionFor(array $initialGrid, array $proposedSolution): bool
    {
        return $this->compliesWithSudokuRules($proposedSolution) && $this->isAMatchFor($initialGrid, $proposedSolution);
    }

    private function isAMatchFor(array $initialGrid, array $proposedSolution): bool
    {
        try {
            $initialSudoku = new SudokuBoard($initialGrid);
            $solvedSudoku = new SudokuBoard($proposedSolution);
        } catch (NonSquareMatrix|TooSmallMatrix $e) {

            return false;
        }

        if (count($initialGrid) != count($proposedSolution)) {

            return false;
        }

        for ($i = 0; $i < count($initialGrid); $i++) {
            for ($j = 0; $j < count($initialGrid); $j++ ) {
                if ($initialGrid[$i][$j] != 0 && $initialGrid[$i][$j] != $proposedSolution[$i][$j]) {

                    return false;
                }
            }
        }

        return true;
    }
}