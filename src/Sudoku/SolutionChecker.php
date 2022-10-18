<?php

declare(strict_types=1);

namespace Sudoku;

class SolutionChecker
{

    public function __construct()
    {
    }

    public function isPossibleSolution(array $matrix): bool
    {
        return $this->isComplete($matrix) &&
            !$this->hasRepeteatedNumberInAnyRow($matrix) &&
            !$this->hasRepeteatedNumberInAnyColumn($matrix) &&
            !$this->hasRepeteatedNumberInAnyQuadrant($matrix);
    }

    private function isComplete(array $matrix): bool
    {
        foreach ($matrix as $row) {
            if (array_search(0, $row)) {

                return false;
            }
        }

        return true;
    }

    private function hasRepeteatedNumberInAnyRow(array $matrix): bool
    {
        foreach ($matrix as $row) {
            if ($this->hasRepeatedNumber($row)) {

                return true;
            }
        }

        return false;
    }

    private function hasRepeteatedNumberInAnyColumn(array $matrix): bool
    {
        for ($i = 0; $i < count($matrix); $i++) {
            if ($this->hasRepeatedNumber(array_column($matrix, $i))) {

                return true;
            }
        }

        return false;
    }

    private function hasRepeteatedNumberInAnyQuadrant(array $matrix): bool
    {
        foreach ($this->buildQuadrants($matrix) as $quadrant) {
            if ($this->hasRepeatedNumber($this->quadrant2row($quadrant))) {

                return true;
            }
        }

        return false;
    }

    private function hasRepeatedNumber(array $array): bool
    {
        foreach ($array as $k => $number) {
            if (array_search($number, $array) !== $k) {

                return true;
            }
        }

        return false;
    }

    private function buildQuadrants(array $matrix): array
    {
        $quadrants = [];

        for ($i = 0; $i < sqrt(count($matrix)); $i++) {
            $quadrants[] = $this->buildQuadrant($matrix, $i);
        }

        return $quadrants;
    }

    private function quadrant2row(array $quadrant): array
    {
        $plain = [];

        for ($i = 0; $i < count($quadrant); $i++ ) {
            for ($j = 0; $j < count($quadrant); $j++ ) {
                $plain[] = $quadrant[$i][$j];
            }
        }

        return $plain;
    }

    private function buildQuadrant(array $matrix, int $q): array
    {
        $quadrant = [];

        for ($i = 0; $i < sqrt(count($matrix)); $i++) {
            $quadrant[$i] = [];
            for ($j = 0; $j < sqrt(count($matrix)); $j++) {
                $quadrant[$i][$j] = $matrix[$q * $i + $i][$q * $j + $j];
            }
        }

        return $quadrant;
    }
}