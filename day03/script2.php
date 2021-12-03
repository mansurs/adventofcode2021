<?php

$binaries = array_filter(explode("\n", file_get_contents('input.txt')));
//$binaries = array_filter(explode("\n", file_get_contents('example.txt')));

$allCount = count($binaries);
$numChars = strlen($binaries[0]);

function filterBins($binaries, $position) {
    $bins = [
        0 => [],
        1 => [],
    ];
    foreach ($binaries as $binary) {
        $bins[$binary[$position]][] = $binary;
    }
    return $bins;
}

$bins = $binaries;
for ($i = 0; $i < $numChars; $i++) {
    $binsNew = filterBins($bins, $i);
    if (count($binsNew[0]) + count($binsNew[1]) == 1) {
        $bins = array_merge($binsNew[0], $binsNew[1]);
        break;
    }
    if (count($binsNew[1]) >= count($binsNew[0])) {
        $bins = $binsNew[1];
    } else {
        $bins = $binsNew[0];
    }
}
$oxygen = end($bins);


$bins = $binaries;
for ($i = 0; $i < $numChars; $i++) {
    $binsNew = filterBins($bins, $i);
    if (count($binsNew[0]) + count($binsNew[1]) == 1) {
        $bins = array_merge($binsNew[0], $binsNew[1]);
        break;
    }
    if (count($binsNew[0]) <= count($binsNew[1])) {
        $bins = $binsNew[0];
    } else {
        $bins = $binsNew[1];
    }
}
$co2 = end($bins);


$oxygenDec = bindec($oxygen);
$co2Dec = bindec($co2);
var_dump($oxygenDec, $co2Dec, $oxygenDec * $co2Dec);


