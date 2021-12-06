<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = explode("\n", file_get_contents('input.txt'));

$laternfishes = array_fill(0, 9, 0);

foreach (explode(",", reset($fileContent)) as $initFish) {
    $laternfishes[$initFish]++;
}

for ($i = 0; $i < 256; $i++) {
    $birthFishes = $laternfishes[0];
    for ($j = 1; $j < count($laternfishes); $j++) {
        $laternfishes[$j - 1] = $laternfishes[$j];
    }
    $laternfishes[6] += $birthFishes;
    $laternfishes[8] = $birthFishes;
}

echo "num: " . array_sum($laternfishes) . "\n";
