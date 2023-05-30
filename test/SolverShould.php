<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;

class SolverShould extends TestCase
{
    /**
     * @test
     * @dataProvider gridsProvider
     */
    public function generate_valid_solutions_for_any_valid_grid(array $initialGrid, array $possibleSolutions): void
    {
        $solver = new Solver();
        $this->assertContains($solver->getSolutionFor($initialGrid), $possibleSolutions);
    }

    public function gridsProvider(): array
    {
        return [
            [$this->buildSingleSolutionGrid(), $this->buildSolutionForSingleSolutionGrid()]
        ];
    }

    private function buildSingleSolutionGrid(): array
    {
        return [
            [1, 0, 0, 4,],
            [3, 0, 0, 2,],
            [0, 1, 4, 0,],
            [0, 3, 0, 1,],
        ];
    }

    private function buildSolutionForSingleSolutionGrid(): array
    {
        return
            [
                [
                    [1, 2, 3, 4,],
                    [3, 4, 1, 2,],
                    [2, 1, 4, 3,],
                    [4, 3, 2, 1,],
                ],
            ];
    }
}