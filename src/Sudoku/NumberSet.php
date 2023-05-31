<?php

declare(strict_types=1);

namespace Sudoku;

class NumberSet
{
    private array $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function hasRepeatedNumber(): bool
    {
        foreach ($this->array as $k => $number) {
            if (array_search($number, $this->array) !== $k) {

                return true;
            }
        }

        return false;
    }

    public function diff(NumberSet ...$otherSets): NumberSet
    {
        return $this;
    }
}