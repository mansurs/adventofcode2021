<?php

$fileContent = explode("\n", file_get_contents('example.txt'));
//$fileContent = explode("\n", file_get_contents('input.txt'));

$crabs = explode(",", reset($fileContent));

function median(array $numbers)
{
    rsort($numbers);
    $mid = (count($numbers) / 2);
    return ($mid % 2 != 0) ? $numbers[$mid-1] : (($numbers[$mid-1]) + $numbers[$mid]) / 2;
}

function getDistance(array $numbers, $to) {
    $distance = 0;
    foreach ($numbers as $number) {
        $distance += (abs($number - $to) * (abs($number - $to) + 1)) / 2;
    }
    return $distance;
}

$bestCost = getDistance($crabs, median($crabs));
for ($i = min($crabs); $i <= max($crabs); $i++) {
    $cost = getDistance($crabs, $i);
    if ($cost < $bestCost) {
        $bestCost = $cost;
    }
}
var_dump($bestCost);