<?php

$binaries = array_filter(explode("\n", file_get_contents('input.txt')));

$allCount = count($binaries);
$countOnes = [];

foreach ($binaries as $binary) {
    for ($i = 0; $i < strlen($binary); $i++) {
        if (!isset($countOnes[$i])) {
            $countOnes[$i] = 0;
        }
        $countOnes[$i] += $binary[$i];
    }
}

$gamma = '';
$epsilon = '';

for ($i = 0; $i < count($countOnes); $i++) {
    if ($countOnes[$i] > $allCount / 2) {
        $gamma .= '1';
        $epsilon .= '0';
    } else {
        $gamma .= '0';
        $epsilon .= '1';
    }
}

$gammaDec = bindec($gamma);
$epsilonDec = bindec($epsilon);
var_dump($gammaDec * $epsilonDec);


