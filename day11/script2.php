<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$matrixCount = 0;
$matrix = [];
foreach ($fileContent as $line) {
    $matrix[] = str_split($line);
    $matrixCount += strlen($line);
}

$ni = [
    ['r' => 0, 'c' => -1],
    ['r' => 0, 'c' => 1],
    ['r' => -1, 'c' => -1],
    ['r' => -1, 'c' => 0],
    ['r' => -1, 'c' => 1],
    ['r' => 1, 'c' => -1],
    ['r' => 1, 'c' => 0],
    ['r' => 1, 'c' => 1],
];

$flashes = [];
function incVal($i, $rowKey, $colKey) {
    global $ni, $flashes, $matrix;
    $matrix[$rowKey][$colKey] = 0;
    if (!isset($flashes[$i])) $flashes[$i] = [];
    $flashes[$i][$rowKey . 'x' . $colKey] = true;
    foreach ($ni as $n) {
        $r = $rowKey + $n['r'];
        $c = $colKey + $n['c'];
        if (!isset($matrix[$r][$c])) {
            continue;
        }
        if ($matrix[$r][$c] == 9) {
            incVal($i,$r, $c);
        } elseif ($matrix[$r][$c] == 0 && isset($flashes[$i][$r . 'x' . $c])) {
            continue;
        } else {
            $matrix[$r][$c]++;
        }
    }
}

function printMatrix($matrix) {
    foreach ($matrix as $row) {
        echo implode("", $row) . "\n";
    }
}

for ($i = 0; $i < 1000; $i++) {
    for ($rowKey = 0; $rowKey < count($matrix); $rowKey++) {
        for ($colKey = 0; $colKey < count($matrix[$rowKey]); $colKey++) {
            if ($matrix[$rowKey][$colKey] == 9) {
                incVal($i, $rowKey, $colKey);
            } elseif ($matrix[$rowKey][$colKey] == 0 && isset($flashes[$i][$rowKey . 'x' . $colKey])) {
                continue;
            } else {
                $matrix[$rowKey][$colKey]++;
            }
        }
    }
    if (isset($flashes[$i]) && count($flashes[$i]) == $matrixCount) {
        printMatrix($matrix);
        var_dump("ALL FLASHES AT STEP " . ($i+1));
        exit;
    }
}

$flashesCount = 0;
foreach ($flashes as $flash) {
    $flashesCount += count($flash);
}

printMatrix($matrix);
var_dump($flashesCount);
