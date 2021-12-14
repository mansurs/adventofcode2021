<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$dots = [];
$instructions = [];
$matrix = [];
foreach ($fileContent as $line) {
    if (preg_match('/(\d+),(\d+)/', $line, $matches)) {
        $dots[] = array_slice($matches, 1);
        if (!isset($matrix[$matches[2]])) {
            $matrix[$matches[2]] = [];
        }
        $matrix[$matches[2]][$matches[1]] = 1;
    } elseif (preg_match('/fold along (\w)=(\d+)/', $line, $matches)) {
        $instructions[] = array_slice($matches, 1);
    }
}

$folds = [];
foreach ($instructions as $ins => $instruction) {
    $folds[$ins] = [];
    if ($instruction[0] == 'y') {
        $iMax = max(array_keys($matrix));
        for ($i = 0; $i <= $iMax; $i++) {
            if (!isset($matrix[$i])) {
                continue;
            }
            if ($i < $instruction[1]) {
                $folds[$ins][$i] = $matrix[$i];
            } else {
                $ins2 = $instruction[1] - ($i - $instruction[1]);
                if (isset($folds[$ins][$ins2])) {
                    $folds[$ins][$ins2] += $matrix[$i];
                } else {
                    $folds[$ins][$ins2] = $matrix[$i];
                }
            }
        }
    } elseif ($instruction[0] == 'x') {
        $yMax = max(array_keys($matrix));
        for ($y = 0; $y <= $yMax; $y++) {
            if (!isset($matrix[$y])) {
                continue;
            }
            $xMax = max(array_keys($matrix[$y]));
            for ($x = 0; $x <= $xMax; $x++) {
                if (!isset($matrix[$y][$x])) {
                    continue;
                }
                if ($x < $instruction[1]) {
                    $folds[$ins][$y][$x] = $matrix[$y][$x];
                } else {
                    $x2 = $instruction[1] - ($x - $instruction[1]);
                    $folds[$ins][$y][$x2] = $matrix[$y][$x];
                }
            }
        }
    }
    break;
}

$sumDots = 0;
foreach ($folds[0] as $fold) {
    $sumDots += array_sum($fold);
}
var_dump($sumDots);