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

        $this->assertEquals($isSolution, $solutionChecker->isSolutionFor($proposedSolution, $initialGrid));
    }

    public function gridsProvider(): array
    {
        return [
            [ $this->buildInitialGrid(), $this->buildCorrectSolution(), true ],
        ];
    }

    private function buildInitialGrid(): array
    {
        return [
            5,3,0,0,7,0,0,0,0,
            6,0,0,1,9,5,0,0,0,
            0,9,8,0,0,0,0,6,0,
            8,0,0,0,6,0,0,0,3,
            4,0,0,8,7,3,0,0,1,
            7,0,0,0,2,0,0,0,6,
            0,6,0,0,0,0,2,8,0,
            0,0,0,4,1,9,0,0,5,
            0,1,0,0,8,0,0,7,9,
        ];
    }

    private function buildCorrectSolution(): array
    {
        return [
            5,3,4,6,7,8,9,1,2,
            6,7,2,1,9,5,3,4,8,
            1,9,8,3,4,2,5,6,7,
            8,5,9,7,6,1,4,2,3,
            4,2,6,8,5,3,7,9,1,
            7,1,3,9,2,4,8,5,6,
            9,6,1,5,3,7,2,8,4,
            2,8,7,4,1,9,6,3,5,
            3,4,5,2,8,6,1,7,9,
        ];
    }
}