<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$matrix = [];
foreach ($fileContent as $line) {
    $matrix[] = str_split($line);
}

$foundValues = [];
foreach ($matrix as $rowKey => $row) {
    foreach ($row as $colKey => $val) {
        $neighbours = [];
        if (isset($matrix[$rowKey-1][$colKey])) {
            $neighbours[] = $matrix[$rowKey-1][$colKey];
        }
        if (isset($matrix[$rowKey+1][$colKey])) {
            $neighbours[] = $matrix[$rowKey+1][$colKey];
        }
        if (isset($matrix[$rowKey][$colKey-1])) {
            $neighbours[] = $matrix[$rowKey][$colKey-1];
        }
        if (isset($matrix[$rowKey][$colKey+1])) {
            $neighbours[] = $matrix[$rowKey][$colKey+1];
        }
        foreach ($neighbours as $n) {
            if ($n <= $val) {
                continue 2;
            }
        }
        $foundValues[] = $val;
    }
}

//var_dump($foundValues);

$sum = array_sum($foundValues) + count($foundValues);

var_dump($sum);