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
        return array_map(static fn(array $row): NumberSet => new NumberSet($row), $this->matrix);
    }

    private function columns(): array
    {
        $columns = [];

        for ($i = 0; $i < count($this->matrix); $i++) {
            $columns[] = new NumberSet(array_column($this->matrix, $i));
        }

        return $columns;
    }

    /**
     */
    private function quadrants(): array
    {
        $quadrants = [];

        $quadrantSize = (int)sqrt(count($this->matrix));
        for ($i = 0; $i < count($this->matrix); $i += $quadrantSize) {
            for ($j = 0; $j < count($this->matrix); $j += $quadrantSize) {
                $quadrants[] = new NumberSet($this->buildQuadrant($i, $j));
            }
        }

        return $quadrants;
    }

    /**
     * @param int $quadrantStartRow
     * @param int $quadrantStartCol
     * @return array
     */
    private function buildQuadrant(int $quadrantStartRow, int $quadrantStartCol): array
    {
        $quadrant = [];

        $quadrantSize = sqrt(count($this->matrix));
        for ($i = 0; $i < $quadrantSize; $i++) {
            for ($j = 0; $j < $quadrantSize; $j++) {
                $quadrant[] = $this->matrix[$quadrantStartRow + $i][$quadrantStartCol + $j];
            }
        }

        return $quadrant;
    }
}