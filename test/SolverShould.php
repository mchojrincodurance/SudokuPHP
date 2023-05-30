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
            [$this->buildSingleSolutionGrid(0), $this->buildSolutionForSingleSolutionGrid(0)],
            [$this->buildSingleSolutionGrid(1), $this->buildSolutionForSingleSolutionGrid(1)]
        ];
    }

    private function buildSingleSolutionGrid(int $index): array
    {
        $initilaGrids[0] =
            [
                [1, 0, 0, 4,],
                [3, 0, 0, 2,],
                [0, 1, 4, 0,],
                [0, 3, 0, 1,],
            ];

        $initilaGrids[1] =
            [
                [1, 2, 4, 3,],
                [0, 0, 0, 0,],
                [4, 0, 3, 0,],
                [0, 0, 0, 4,],
            ];

        return $initilaGrids[$index];
    }

    private function buildSolutionForSingleSolutionGrid(int $index): array
    {
        $solutions[0] = [
            [1, 2, 3, 4,],
            [3, 4, 1, 2,],
            [2, 1, 4, 3,],
            [4, 3, 2, 1,],
        ];

        $solutions[1] = [
            [1, 2, 4, 3,],
            [3, 4, 2, 1,],
            [4, 1, 3, 2,],
            [2, 3, 1, 4,],
        ];

        return
            [
                $solutions[$index],
            ];
    }
}