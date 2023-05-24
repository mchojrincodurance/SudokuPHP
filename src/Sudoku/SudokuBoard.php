<?php

declare(strict_types=1);

namespace Sudoku;

use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;

class SudokuBoard
{
    private array $matrix;

    /**
     * @param array $matrix
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     */
    public function __construct(array $matrix)
    {
        if ($this->isNotSquare($matrix)) {

            throw new NonSquareMatrix();
        }

        if ($this->isSmallerThan4By4($matrix)) {

            throw new TooSmallMatrix();
        }

        $this->matrix = $matrix;
    }

    private function isNotSquare(array $matrix): bool
    {
        return count($matrix) !== count(current($matrix));
    }

    private function isSmallerThan4By4(array $matrix): bool
    {
        return count($matrix) < 4;
    }

    public function isComplete(): bool
    {
        foreach ($this->matrix as $row) {
            if (array_search(0, $row)) {

                return false;
            }
        }

        return true;
    }

    public function hasRepeatedNumberInAnyRow(): bool
    {
        foreach ($this->rows() as $row) {
            if ($row->hasRepeatedNumber()) {

                return true;
            }
        }

        return false;
    }

    public function hasRepeatedNumberInAnyColumn(): bool
    {
        foreach ($this->columns() as $column) {
            if ($column->hasRepeatedNumber()) {

                return true;
            }
        }

        return false;
    }

    /**
     * @throws NonSquareMatrix
     */
    public function hasRepeatedNumberInAnyQuadrant(): bool
    {
        foreach ($this->quadrants() as $quadrant) {
            if ($quadrant->hasRepeatedNumber()) {

                return true;
            }
        }

        return false;
    }

    private function rows(): array
    {
        $rows = [];
        foreach ($this->matrix as $row) {
            $rows[] = new Row($row);
        }

        return $rows;
    }

    private function columns(): array
    {
        $columns = [];

        for($i = 0; $i < count($this->matrix); $i++) {
            $columns[] = new Row(array_column($this->matrix, $i));
        }

        return $columns;
    }

    /**
     * @throws NonSquareMatrix
     */
    private function quadrants(): array
    {
        $quadrants = [];

        for ($i = 0; $i < sqrt(count($this->matrix)); $i++) {
            $quadrants[] = $this->buildQuadrant($i);
        }

        return $quadrants;
    }

    /**
     * @throws NonSquareMatrix
     */
    private function buildQuadrant(int $q): Quadrant
    {
        $quadrant = [];

        for ($i = 0; $i < sqrt(count($this->matrix)); $i++) {
            $quadrant[$i] = [];
            for ($j = 0; $j < sqrt(count($this->matrix)); $j++) {
                $quadrant[$i][$j] = $this->matrix[$q * $i + $i][$q * $j + $j];
            }
        }

        return new Quadrant($quadrant);
    }
}