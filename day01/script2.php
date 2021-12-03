<?php

$numbers = array_filter(explode("\n", file_get_contents('input.txt')));

$increased = 0;
$decreased = 0;
for ($i = 3; $i < count($numbers); $i++) {
    $x = array_sum(array_slice($numbers, $i-2, 3));
    $y = array_sum(array_slice($numbers, $i-3, 3));
    if ($x > $y) {
        $increased++;
    } elseif ($x < $y) {
        $decreased++;
    } else {
        echo "WTF\n";
    }
}

echo "$increased increased\n";
echo "$decreased decreased\n";