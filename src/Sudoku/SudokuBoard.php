<?php

declare(strict_types=1);

namespace Sudoku;

use Ds\Set;
use InvalidArgumentException;
use Sudoku\Exception\InvalidSquareReference;
use Sudoku\Exception\NonSquareMatrix;
use Sudoku\Exception\TooSmallMatrix;
use Sudoku\Exception\IllegallyRepeatedNumbers;
use Sudoku\Exception\NotEmptySquare;

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

    public function isComplete(): bool
    {
        return empty($this->getIncompleteRows());
    }

    private function isSquare(array $matrix): bool
    {
        return count($matrix) === count(current($matrix));
    }

    private function isSmallerThan4By4(array $matrix): bool
    {
        return count($matrix) < 4;
    }

    private function hasRepeatedNumber(array $array): bool
    {
        return array_filter($array) !== array_unique(array_filter($array));
    }

    private function hasRepeatedNumberInAnyRow(array $matrix): bool
    {
        return !empty(
        array_filter(
            $matrix, fn(array $row) => $this->hasRepeatedNumber($row)
        )
        );
    }

    public function hasRepeatedNumberInAnyColumn(array $matrix): bool
    {
        return !empty(
        array_filter(
            array_map(
                static function (int $col) use ($matrix) {
                    return array_column($matrix, $col);
                },
                range(0, count($matrix) - 1)
            ), fn(array $col) => $this->hasRepeatedNumber($col)
        )
        );
    }

    /**
     */
    public function hasRepeatedNumberInAnyQuadrant(array $matrix): bool
    {
        $quadrantSize = (int)sqrt(count($matrix));
        $quadrants = [];

        for ($i = 0; $i < $quadrantSize; $i++) {
            for ($j = 0; $j < $quadrantSize; $j++) {
                $quadrants[] = $this->buildQuadrant($matrix, $i * $quadrantSize, $j * $quadrantSize);
            }
        }

        return !empty(array_filter($quadrants, fn(array $quadrant) => $this->hasRepeatedNumber($quadrant)));
    }

    public
    function rows(): array
    {
        return array_map(static fn(array $row): Set => new Set($row), $this->matrix);
    }

    public
    function columns(): array
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
     * @param array $matrix
     * @param int $quadrantStartRow
     * @param int $quadrantStartCol
     * @return array
     */
    private
    function buildQuadrant(array $matrix, int $quadrantStartRow, int $quadrantStartCol): array
    {
        $quadrant = [];

        $quadrantSize = (int)sqrt(count($matrix));
        for ($i = 0; $i < $quadrantSize; $i++) {
            for ($j = 0; $j < $quadrantSize; $j++) {
                $quadrant[] = $matrix[$quadrantStartRow + $i][$quadrantStartCol + $j];
            }
        }

        return $quadrant;
    }

    public
    function size(): int
    {
        return count($this->matrix);
    }

    public
    function valueAt(int $row, int $col): int
    {
        if ($row < 0 || $row >= $this->size() || $col < 0 || $col >= $this->size()) {

            throw new InvalidArgumentException();
        }

        return $this->matrix[$row][$col];
    }

    public
    function setSquare(array $square, int $value): void
    {
        $this->matrix[$square[0]][$square[1]] = $value;
    }

    public
    function row(int $row): Set
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
    private
    function hasIllegallyRepeatedNumbers(array $matrix): bool
    {
        return $this->hasRepeatedNumberInAnyColumn($matrix) ||
            $this->hasRepeatedNumberInAnyRow($matrix) ||
            $this->hasRepeatedNumberInAnyQuadrant($matrix);
    }

    private
    function hasRepeatedNumberInQuadrant(array $matrix, int $firstRow, int $firstCol): bool
    {
        $size = (int)sqrt(count($matrix));
        $array = [];

        for ($i = $firstRow; $i < $firstRow + $size; $i++) {
            for ($j = $firstCol; $j < $firstCol + $size; $j++) {
                $array[] = $matrix[$i][$j];
            }
        }

        $array = array_filter($array);

        return array_unique($array) !== $array;
    }

    /**
     * @param array $matrix
     * @return void
     * @throws NonSquareMatrix
     */
    private
    function validateShape(array $matrix): void
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
    private
    function validateSize(array $matrix): void
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
    private
    function validateRepeatedNumbers(array $matrix): void
    {
        if ($this->hasIllegallyRepeatedNumbers($matrix)) {

            throw new IllegallyRepeatedNumbers();
        }
    }

    /**
     * @return bool[]
     */
    protected
    function getIncompleteRows(): array
    {
        return array_filter(
            $this->rows(),
            fn(Set $row) => $row->count() < $this->size()
        );
    }

    /**
     * @throws NonSquareMatrix
     * @throws IllegallyRepeatedNumbers
     * @throws TooSmallMatrix
     * @throws NotEmptySquare
     * @throws InvalidSquareReference
     */
    public
    function addNumber(int $row, int $col, int $value): SudokuBoard
    {
        if ($row < 0 || $row >= $this->size() || $col < 0 || $col >= $this->size()) {

            throw new InvalidSquareReference();
        }

        if (!empty($this->matrix[$row][$col])) {

            throw new NotEmptySquare();
        }
        $newMatrix = $this->matrix;
        $newMatrix[$row][$col] = $value;

        return new SudokuBoard($newMatrix);
    }
}