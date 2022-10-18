<?php

declare(strict_types=1);

namespace Sudoku;

use PHPUnit\Framework\TestCase;

class SolutionCheckerTest extends TestCase
{
    /**
     * @test
     * @dataProvider matrixProvider
     */
    public function recognize_valid_matrices(array $matrix, bool $expectedResult): void
    {
        $solutionChecker = new SolutionChecker();
        $this->assertEquals($expectedResult, $solutionChecker->isPossibleSolution($matrix));
    }

    public function matrixProvider(): array
    {
        return
            [
                [
                    [
                        [1, 1, 3, 4,],
                        [3, 2, 4, 1,],
                        [2, 4, 1, 3,],
                        [4, 3, 2, 1,],
                    ],
                    false,
                ],
                [
                    [
                        [1, 2, 3, 4,],
                        [2, 1, 4, 3,],
                        [3, 4, 1, 2,],
                        [4, 3, 2, 1,],
                    ],
                    false,
                ],
                [
                    [
                        [1, 2, 3, 4,],
                        [2, 1, 4, 3,],
                        [3, 4, 0, 2,],
                        [4, 0, 2, 1,],
                    ],
                    false,
                ],
                [
                    [
                        [1, 2, 3, 4,],
                        [3, 4, 1, 2,],
                        [2, 3, 4, 1,],
                        [4, 1, 2, 3,],
                    ],
                    true,
                ]
            ];
    }
}
