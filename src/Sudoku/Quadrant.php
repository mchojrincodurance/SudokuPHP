<?php

declare(strict_types=1);

namespace Sudoku;

use Sudoku\Exception\NonSquareMatrix;

class Quadrant
{
    private array $matrix;

    /**
     * @throws NonSquareMatrix
     */
    public function __construct(array $matrix)
    {
        if (!$this->isSquare($matrix)) {

            throw new NonSquareMatrix();
        }

        $this->matrix = $matrix;
    }

    public function hasRepeatedNumber() : bool
    {
        for ($i = 0; $i < count($this->matrix); $i++ ) {
            for ($j = 0; $j < count($this->matrix); $j++ ) {
                if ($this->isRepeated($this->matrix[$i][$j], $i, $j)) {

                    return true;
                }
            }
        }

        return false;
    }

    private function isSquare(array $matrix): bool
    {
        return count($matrix) == count(current($matrix));
    }

    private function isRepeated(int $number, int $row, int $col): bool
    {
        for ($i = 0; $i < count($this->matrix); $i++) {
            for ($j = 0; $j < count($this->matrix); $j++) {
                if ($this->matrix[$i][$j] == $number && $i == $row && $j == $col) {

                    return true;
                }
            }
        }

        return false;
    }
}