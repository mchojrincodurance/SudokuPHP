<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;

class SolutionCheckerShould extends TestCase
{
    /**
     * @test
     * @dataProvider gridsProvider
     */
    public function recognize_correct_solutions_for_initial_grids(array $initialGrid, array $proposedSolution, bool $isSolution): void
    {
        $solutionChecker = new SolutionChecker();

        $this->assertEquals($isSolution, $solutionChecker->isSolutionFor($initialGrid, $proposedSolution));
    }

    public function gridsProvider(): array
    {
        return [
            [$this->buildInitialGrid(), $this->buildCorrectSolution(), true],
            [$this->buildInitialGrid(), $this->buildIncompleteSolution(), false],
            [$this->buildInitialGrid(), $this->buildRepeatedNumberInColumn(), false],
            [$this->buildInitialGrid(), $this->buildRepeatedNumberInRow(), false],
            [$this->buildInitialGrid(), $this->buildRepeatedNumberInQuadrant(), false],
            [$this->buildInitialGrid(), $this->buildCorrectButUnmatchingSolution(), false],
        ];
    }

    private function buildInitialGrid(): array
    {
        return [
            [0, 0, 0, 0, 0, 3, 2, 9, 0,],
            [0, 8, 6, 5, 0, 0, 0, 0, 0,],
            [0, 2, 0, 0, 0, 1, 0, 0, 0,],
            [0, 0, 3, 7, 0, 5, 1, 0, 0,],
            [9, 0, 0, 0, 0, 0, 0, 0, 8,],
            [0, 0, 2, 9, 0, 8, 3, 0, 0,],
            [0, 0, 0, 4, 0, 0, 0, 8, 0,],
            [0, 0, 0, 0, 0, 6, 4, 7, 0,],
            [0, 4, 7, 1, 0, 0, 0, 0, 0,],
        ];
    }

    private function buildCorrectSolution(): array
    {
        return [
            [1, 5, 4, 8, 7, 3, 2, 9, 6,],
            [3, 8, 6, 5, 9, 2, 7, 1, 4,],
            [7, 2, 9, 6, 4, 1, 8, 3, 5,],
            [8, 6, 3, 7, 2, 5, 1, 4, 9,],
            [9, 7, 5, 3, 1, 4, 6, 2, 8,],
            [4, 1, 2, 9, 6, 8, 3, 5, 7,],
            [6, 3, 1, 4, 5, 7, 9, 8, 2,],
            [5, 9, 8, 2, 3, 6, 4, 7, 1,],
            [2, 4, 7, 1, 8, 9, 5, 6, 3,],
        ];
    }

    private function buildIncompleteSolution(): array
    {
        return [
            [5, 3, 4, 6, 7, 8, 9, 1, 2,],
            [6, 7, 2, 1, 9, 5, 3, 4, 8,],
            [1, 9, 8, 3, 4, 2, 5, 6, 7,],
            [8, 5, 9, 7, 6, 1, 4, 2, 3,],
            [4, 2, 6, 8, 5, 3, 7, 9, 1,],
            [7, 1, 3, 9, 2, 4, 8, 5, 6,],
            [9, 6, 1, 5, 3, 7, 2, 8, 4,],
            [2, 8, 7, 4, 1, 9, 6, 3, 5,],
            [3, 4, 5, 2, 8, 6, 1, 7, 0,],
        ];
    }

    private function buildRepeatedNumberInColumn(): array
    {
        return [
            [5, 3, 4, 6, 7, 8, 9, 1, 2,],
            [6, 7, 2, 1, 9, 5, 3, 4, 8,],
            [1, 9, 8, 3, 4, 2, 5, 6, 7,],
            [8, 5, 9, 7, 6, 1, 4, 2, 3,],
            [4, 2, 6, 8, 5, 3, 7, 9, 1,],
            [7, 1, 3, 9, 2, 4, 8, 5, 6,],
            [9, 6, 1, 5, 3, 7, 2, 8, 4,],
            [2, 8, 7, 4, 1, 9, 6, 3, 5,],
            [3, 4, 5, 2, 8, 6, 1, 7, 6,],
        ];
    }

    private function buildRepeatedNumberInRow(): array
    {
        return [
            [5, 3, 4, 6, 7, 8, 9, 1, 2,],
            [6, 7, 2, 1, 9, 5, 3, 4, 8,],
            [1, 9, 8, 3, 4, 2, 5, 6, 7,],
            [8, 5, 9, 7, 6, 1, 4, 2, 3,],
            [4, 2, 6, 8, 5, 3, 7, 9, 1,],
            [7, 1, 3, 9, 2, 4, 8, 5, 6,],
            [9, 6, 1, 5, 3, 7, 2, 8, 4,],
            [2, 8, 7, 4, 1, 9, 6, 3, 5,],
            [3, 4, 5, 2, 8, 6, 1, 7, 7,],
        ];
    }

    private function buildRepeatedNumberInQuadrant(): array
    {
        return [
            [5, 3, 4, 6, 7, 8, 9, 1, 2,],
            [6, 7, 2, 1, 9, 5, 3, 4, 8,],
            [1, 9, 8, 3, 4, 2, 5, 6, 7,],
            [8, 5, 9, 7, 6, 1, 4, 2, 3,],
            [4, 2, 6, 8, 5, 3, 7, 9, 1,],
            [7, 1, 3, 9, 2, 4, 8, 5, 6,],
            [9, 6, 1, 5, 3, 7, 2, 8, 4,],
            [2, 8, 7, 4, 1, 9, 6, 3, 5,],
            [3, 4, 5, 2, 8, 6, 1, 7, 3,],
        ];
    }

    private function buildCorrectButUnmatchingSolution(): array
    {
        return [
            [5, 3, 4, 6, 7, 8, 9, 1, 2,],
            [6, 7, 2, 1, 9, 5, 3, 4, 8,],
            [1, 9, 8, 3, 4, 2, 5, 6, 7,],
            [8, 5, 9, 7, 6, 1, 4, 2, 3,],
            [4, 2, 6, 8, 5, 3, 7, 9, 1,],
            [7, 1, 3, 9, 2, 4, 8, 5, 6,],
            [9, 6, 1, 5, 3, 7, 2, 8, 4,],
            [2, 8, 7, 4, 1, 9, 6, 3, 5,],
            [3, 1, 5, 2, 8, 6, 1, 7, 9,],
        ];
    }
}