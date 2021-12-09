<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$matrix = [];
foreach ($fileContent as $line) {
    $matrix[] = str_split($line);
}

$lowPoints = [];
$ni = [
    ['r' => -1, 'c' => 0],
    ['r' => 1, 'c' => 0],
    ['r' => 0, 'c' => -1],
    ['r' => 0, 'c' => 1],
];
foreach ($matrix as $rowKey => $row) {
    foreach ($row as $colKey => $val) {
        $neighbours = [];
        foreach ($ni as $n) {
            if (isset($matrix[$rowKey+$n['r']][$colKey+$n['c']])) {
                $neighbours[] = $matrix[$rowKey+$n['r']][$colKey+$n['c']];
            }
        }
        foreach ($neighbours as $n) {
            if ($n <= $val) {
                continue 2;
            }
        }
        $lowPoints[] = ['row' => $rowKey, 'col' => $colKey, 'val' => $val];
    }
}

function fillBasins($row, $col, &$basins) {
    global $ni, $matrix;
    foreach ($ni as $n) {
        $r = $row+$n['r'];
        $c = $col+$n['c'];
        if (!isset($matrix[$r][$c])) {
            continue;
        }
        $val = $matrix[$r][$c];
        if ($val == 9) {
            continue;
        }
        if ($val < $matrix[$row][$col]) {
            continue;
        }
        $basinXY = $r . 'x' . $c;
        if (isset($basins[$basinXY])) {
            continue;
        }
        $basins[$basinXY] = $val;
        fillBasins($r, $c, $basins);
    }
}

$basins = [];
foreach ($lowPoints as $pointKey => $lowPoint) {
    $basins[$pointKey] = [];
    $basins[$pointKey][$lowPoint['row'] . 'x' . $lowPoint['col']] = $lowPoint['val'];
    fillBasins($lowPoint['row'], $lowPoint['col'], $basins[$pointKey]);
}

$basinCounts = [];
foreach ($basins as $basin) {
    $basinCounts[] = count($basin);
}

arsort($basinCounts);
$finalNumber = array_product(array_slice($basinCounts, 0, 3));
var_dump($finalNumber);

