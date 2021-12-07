<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = explode("\n", file_get_contents('input.txt'));

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
        $distance += abs($number - $to);
    }
    return $distance;
}


//
//$previousNumber = median($crabs);
//$lastDistance = getDistance($crabs, $previousNumber);
//$nextNumber = $previousNumber - 1;
//while (true) {
//    $distance = getDistance($crabs, $nextNumber);
//    if ($distance < $lastDistance) {
//        $nextNumber--;
//    } else {
//        $nextNumber++;
//    }
//    if ($nextNumber == $previousNumber) {
//        echo "FOUND $nextNumber\n";
//        break;
//    }
//}
//
//$bestDistance = median($crabs);
//for ($i = min($crabs); $i <= max($crabs); $i++) {
//
//}

var_dump(array_sum($crabs) / count($crabs));

var_dump(median($crabs), getDistance($crabs, median($crabs)));