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

//$coordinates = array_filter($coordinates, function($xy) {
//    return $xy['x1'] == $xy['x2'] || $xy['y1'] == $xy['y2'];
//});

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
    if ($coordinate['x1'] == $coordinate['y1'] && $coordinate['x2'] == $coordinate['y2']) {
        [$fromY, $toY] = $coordinate['y1'] < $coordinate['y2'] ? ['y1', 'y2'] : ['y2', 'y1'];
        for ($y = $coordinate[$fromY]; $y <= $coordinate[$toY]; $y++) {
            setPoint($field, $y, $y);
        }
    } elseif (abs($coordinate['x1'] - $coordinate['x2']) == abs($coordinate['y1'] - $coordinate['y2'])) {
        [$fromX, $toX, $fromY, $toY] =
            $coordinate['x1'] < $coordinate['x2'] ?
                ['x1', 'x2', 'y1', 'y2'] :
                ['x2', 'x1', 'y2', 'y1'];
        $incY = $coordinate[$fromY] < $coordinate[$toY] ? 1 : -1;
        $y = $coordinate[$fromY];
//        var_dump($coordinate, $fromX, $toX, $incY, $y);
        for ($x = $coordinate[$fromX]; $x <= $coordinate[$toX]; $x++) {
            setPoint($field, $x, $y);
            $y += $incY;
        }
    } elseif ($coordinate['x1'] == $coordinate['x2']) {
        [$fromY, $toY] = $coordinate['y1'] < $coordinate['y2'] ? ['y1', 'y2'] : ['y2', 'y1'];
        for ($y = $coordinate[$fromY]; $y <= $coordinate[$toY]; $y++) {
            setPoint($field, $coordinate['x1'], $y);
        }
    } elseif ($coordinate['y1'] == $coordinate['y2']) {
        [$fromX, $toX] = $coordinate['x1'] < $coordinate['x2'] ? ['x1', 'x2'] : ['x2', 'x1'];
        for ($x = $coordinate[$fromX]; $x <= $coordinate[$toX]; $x++) {
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
//
//foreach ($field as $row) {
//    echo implode(' ', $row) . "\n";
//}