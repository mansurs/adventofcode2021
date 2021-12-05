<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = explode("\n", file_get_contents('input.txt'));

$coordinates = [];
foreach ($fileContent as $line) {
    if (preg_match_all('/(\d+),(\d+) -> (\d+),(\d+)/', $line, $matches)) {
        $coordinates[] = [
            'x1' => $matches[1][0],
            'y1' => $matches[2][0],
            'x2' => $matches[3][0],
            'y2' => $matches[4][0],
        ];
    }
}

$coordinates = array_filter($coordinates, function($xy) {
    return $xy['x1'] == $xy['x2'] || $xy['y1'] == $xy['y2'];
});

$row = array_fill(0, 10, 0);
$field = array_fill(0, 10, $row);

function setPoint(&$field, $x, $y) {
    if (!array_key_exists($y, $field)) {
        $field[$y] = [];
    }
    if (!array_key_exists($x, $field[$y])) {
        $field[$y][$x] = 0;
    }
    $field[$y][$x]++;
}

foreach ($coordinates as $coordinate) {
    $fromX = $coordinate['x1'] < $coordinate['x2'] ? $coordinate['x1'] : $coordinate['x2'];
    $toX = $coordinate['x1'] > $coordinate['x2'] ? $coordinate['x1'] : $coordinate['x2'];
    if ($coordinate['x1'] == $coordinate['x2']) {
//        echo "XEP: " . implode(",", $coordinate) . "\n";
        [$fromY, $toY] = $coordinate['y1'] < $coordinate['y2'] ? ['y1', 'y2'] : ['y2', 'y1'];
        for ($y = $coordinate[$fromY]; $y <= $coordinate[$toY]; $y++) {
//            $field[$y][$coordinate['x1']]++;
            setPoint($field, $coordinate['x1'], $y);
        }
    } elseif ($coordinate['y1'] == $coordinate['y2']) {
//        echo "YEP: " . implode(",", $coordinate) . "\n";
        [$fromX, $toX] = $coordinate['x1'] < $coordinate['x2'] ? ['x1', 'x2'] : ['x2', 'x1'];
//        $inc = $coordinate['x1'] < $coordinate['x2'] ? 1 : -1;
        for ($x = $coordinate[$fromX]; $x <= $coordinate[$toX]; $x++) {
//            $field[$coordinate['y1']][$x]++;
            setPoint($field, $x, $coordinate['y1']);
        }
    } else {
        echo "NOPE: " . implode(",", $coordinate) . "\n";
    }
}

$numOverlaps = 0;
foreach ($field as $row) {
    $numOverlaps += count(array_filter($row, function($val) { return $val > 1; }));
}

echo "Overlaps over 1: $numOverlaps\n";

//foreach ($field as $row) {
//    echo implode(' ', $row) . "\n";
//}