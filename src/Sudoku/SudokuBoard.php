<?php

declare(strict_types=1);

namespace Sudoku;

use Ds\Set;
use InvalidArgumentException;
use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;
use Sudoku\Exception\IllegallyRepeatedNumbers;

class SudokuBoard
{
    private array $matrix;

    /**
     * @param array $matrix
     * @throws NonSquareMatrix
     * @throws TooSmallMatrix
     * @throws IllegallyRepeatedNumbers
     */
    public function __construct(array $matrix)
    {
        $this->validateShape($matrix);
        $this->validateSize($matrix);
        $this->validateRepeatedNumbers($matrix);

        $this->matrix = $matrix;
    }

    private function isSquare(array $matrix): bool
    {
        return count($matrix) === count(current($matrix));
    }

    private function isSmallerThan4By4(array $matrix): bool
    {
        return count($matrix) < 4;
    }

    public function isComplete(): bool
    {
        return empty($this->getIncompleteRows());
    }

    public function hasRepeatedNumberInAnyRow(array $matrix): bool
    {
        for ($i = 0; $i < count($matrix); $i++) {
            $array = array_filter($matrix[$i]);
            if (array_unique($array) !== $array) {

                return true;
            }
        }

        return false;
    }

    public function hasRepeatedNumberInAnyColumn(array $matrix): bool
    {
        for ($i = 0; $i < count($matrix); $i++) {
            $array = array_filter(array_column($matrix, $i));
            if (array_unique($array) !== $array) {

                return true;
            }
        }

        return false;
    }

    /**
     */
    public function hasRepeatedNumberInAnyQuadrant(array $matrix): bool
    {
        $quadrantSize = sqrt(count($matrix));

        for ($i = 0; $i < $quadrantSize; $i += $quadrantSize) {
            for ($j = 0; $j < $quadrantSize; $j += $quadrantSize) {
                if ($this->hasRepeatedNumberInQuadrant($matrix, $i, $j)) {

                    return true;
                }
            }
        }

        return false;
    }

    public function rows(): array
    {
        return array_map(static fn(array $row): Set => new Set($row), $this->matrix);
    }

    public function columns(): array
    {
        return array_map(
            static fn(array $column) => new Set($column),
            array_map(
                fn(int $i) => array_column($this->matrix, $i),
                range(0, $this->size()
                )
            )
        );
    }

    /**
     */
    public function quadrants(): array
    {
        $quadrants = [];

        $quadrantSize = (int)sqrt(count($this->matrix));
        for ($i = 0; $i < count($this->matrix); $i += $quadrantSize) {
            for ($j = 0; $j < count($this->matrix); $j += $quadrantSize) {
                $quadrants[] = new Set($this->buildQuadrant($i, $j));
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

    public function size(): int
    {
        return count($this->matrix);
    }

    public function valueAt(int $row, int $col): int
    {
        if ($row < 0 || $row >= $this->size() || $col < 0 || $col >= $this->size()) {

            throw new InvalidArgumentException();
        }

        return $this->matrix[$row][$col];
    }

    public function setSquare(array $square, int $value): void
    {
        $this->matrix[$square[0]][$square[1]] = $value;
    }

    public function row(int $row): Set
    {
        if ($row < 0 || $row >= $this->size()) {

            throw new InvalidArgumentException();
        }

        return $this->rows()[$row];
    }

    /**
     * @param array $matrix
     * @return bool
     */
    private function hasIllegallyRepeatedNumbers(array $matrix): bool
    {
        return $this->hasRepeatedNumberInAnyColumn($matrix) ||
            $this->hasRepeatedNumberInAnyRow($matrix) ||
            $this->hasRepeatedNumberInAnyQuadrant($matrix);
    }

    private function hasRepeatedNumberInQuadrant(array $matrix, int $firstRow, int $firstCol): bool
    {
        $size = sqrt(count($matrix));
        $array = [];

        for ($i = $firstRow; $i < $firstRow + $size; $i++) {
            for ($j = $firstCol; $j < $firstCol + $size; $j++) {
                $array[] = $matrix[$i][$j];
            }
        }

        return array_unique($array) !== $array;
    }

    /**
     * @param array $matrix
     * @return void
     * @throws NonSquareMatrix
     */
    private function validateShape(array $matrix): void
    {
        if (!$this->isSquare($matrix)) {

            throw new NonSquareMatrix();
        }
    }

    /**
     * @param array $matrix
     * @return void
     * @throws TooSmallMatrix
     */
    private function validateSize(array $matrix): void
    {
        if ($this->isSmallerThan4By4($matrix)) {

            throw new TooSmallMatrix();
        }
    }

    /**
     * @param array $matrix
     * @return void
     * @throws IllegallyRepeatedNumbers
     */
    private function validateRepeatedNumbers(array $matrix): void
    {
        if ($this->hasIllegallyRepeatedNumbers($matrix)) {

            throw new IllegallyRepeatedNumbers();
        }
    }

    /**
     * @return bool[]
     */
    protected function getIncompleteRows(): array
    {
        return array_filter(
            $this->rows(),
            fn(Set $row) => $row->count() < $this->size()
        );
    }

    public function addNumber(int $row, int $col, int $value): SudokuBoard
    {
        return new SudokuBoard($this->matrix);
    }
}