<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$template = null;
$rules = [];
foreach ($fileContent as $line) {
    if (preg_match('/(\w+)\s->\s(\w+)/', $line, $matches)) {
        $rules[$matches[1]] = $matches[2];
    } elseif (preg_match('/^(\w+)$/', $line, $matches)) {
        $template = $matches[1];
    }
}

$firstPair = substr($template, 0, 2);
$lastPair = substr($template, -2);

$pairs = [];
for ($i = 0; $i < strlen($template) - 1; $i++) {
    $pair = substr($template, $i, 2);
    if (!isset($pairs[$pair])) {
        $pairs[$pair] = 0;
    }
    $pairs[$pair]++;
}

for ($x = 0; $x < 40; $x++) {
    $newPairs = $pairs;
    foreach ($pairs as $pair => $pairCount) {
        if ($pairCount === 0) continue;
        if (isset($rules[$pair])) {
            $newPairs[$pair] -= $pairCount;

            $newPair = $pair[0] . $rules[$pair];
            if (!isset($newPairs[$newPair])) {
                $newPairs[$newPair] = 0;
            }
            $newPairs[$newPair] += $pairCount;

            $newPair = $rules[$pair] . $pair[1];
            if (!isset($newPairs[$newPair])) {
                $newPairs[$newPair] = 0;
            }
            $newPairs[$newPair] += $pairCount;
        }
    }
    $pairs = $newPairs;
}

$charCounts = [];
var_dump($pairs);
foreach ($pairs as $pair => $pairCount) {
    if (!isset($charCounts[$pair[0]])) {
        $charCounts[$pair[0]] = 0;
    }
    if (!isset($charCounts[$pair[1]])) {
        $charCounts[$pair[1]] = 0;
    }
    $charCounts[$pair[0]] += $pairCount;
    $charCounts[$pair[1]] += $pairCount;
}

unset($charCounts['x']);

var_dump($charCounts);

rsort($charCounts);

$countMostChar = ceil(reset($charCounts) / 2);
$countLeastChar = ceil(end($charCounts) / 2);

var_dump($countMostChar, $countLeastChar, $countMostChar - $countLeastChar);
