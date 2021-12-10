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
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

$totalPoints = [];
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
                continue 2;
            }
        }
    }
    if (count($toCloseStack) > 0) {
        $points = 0;
        while ($lastClose = array_pop($toCloseStack)) {
            $points *= 5;
            $points += $pairsClose[$lastClose];
        };
        $totalPoints[] = $points;
    }
}

sort($totalPoints);


var_dump($totalPoints[(int)(count($totalPoints) / 2)]);