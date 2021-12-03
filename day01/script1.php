<?php

$numbers = array_filter(explode("\n", file_get_contents('input.txt')));

$increased = 0;
$decreased = 0;
for ($i = 1; $i < count($numbers); $i++) {
    if ($numbers[$i] > $numbers[$i-1]) {
        $increased++;
    } elseif ($numbers[$i] < $numbers[$i-1]) {
        $decreased++;
    } else {
        echo "WTF\n";
    }
}

echo "$increased increased\n";
echo "$decreased decreased\n";