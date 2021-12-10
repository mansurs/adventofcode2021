<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$pairsOpen = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];
$pairsClose = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$points = 0;
foreach ($fileContent as $lineNumber => $line) {
    $line = str_split($line);
    $toCloseStack = [];
    foreach ($line as $char) {
        if (isset($pairsOpen[$char])) {
            $toCloseStack[] = $pairsOpen[$char];
            continue;
        }
        if (isset($pairsClose[$char])) {
            $lastClose = array_pop($toCloseStack);
            if ($char != $lastClose) {
                $points += $pairsClose[$char];
                continue 2;
            }
        }
    }
//    if (count($toCloseStack) > 0) {
//        $lastClose = array_pop($toCloseStack);
//        $points += $pairsClose[$lastClose];
//    }
}

var_dump($points);