<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Sudoku\SolutionChecker;

$solutionChecker = new SolutionChecker();
$inputFile = fopen($argv[1], "r");
$matrix = [];
while (!feof($inputFile)) {
    $readCSV = fgetcsv($inputFile);
    if (!empty($readCSV)) {
        $matrix[] = array_map(static fn(string $value) => (int)$value, array_slice($readCSV, 0, -1));
    }
}

echo $solutionChecker->isPossibleSolution($matrix) ? "The input complies with Sudoku's rules." : "The input doesn't comply with Sudoku's rules.";