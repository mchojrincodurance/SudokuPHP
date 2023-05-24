<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Sudoku\SolutionChecker;

$solutionChecker = new SolutionChecker();
echo $solutionChecker->compliesWithSudokuRules(readMatrixFrom($argv[1])) ? "The input complies with Sudoku's rules." : "The input doesn't comply with Sudoku's rules.";

function readMatrixFrom(string $inputFileName): array
{
    $inputFile = fopen($inputFileName, "r");
    $matrix = [];
    while (!feof($inputFile)) {
        $readCSV = fgetcsv($inputFile);
        if (!empty($readCSV)) {
            $matrix[] = array_map(static fn(string $value) => (int)$value, array_slice($readCSV, 0, -1));
        }
    }

    return $matrix;
}
