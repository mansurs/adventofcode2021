<?php

//$fileContent = explode("\n", file_get_contents('example2.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

function explodeSnailNumber(string $sn) {
    $openStack = [];
    for ($i = 0; $i < strlen($sn); $i++) {
        if ($sn[$i] == '[') {
            $openStack[] = $i;
            $checkPair = substr($sn, $i);
            if (count($openStack) >= 5 && preg_match('/^\[\d+,\d+\]/', $checkPair)) {
                $closing = strpos($sn, ']', $i);
                $pair = substr($sn, $i, $closing - $i + 1);
                $pair = json_decode($pair, true);
                $leftSn = substr($sn, 0, $i);
                $rightSn = substr($sn, $closing+1);
                preg_match('/(\d+)[^\d]+/', $leftSn, $matches, PREG_OFFSET_CAPTURE);
                $leftSn = preg_replace_callback(
                    '/(\d+)([^\d]+)$/',
                    function ($matches) use ($pair) {
                            return ($matches[1]+$pair[0]) . $matches[2];
                        },
                    $leftSn
                );
                $rightSn = preg_replace_callback(
                    '/^([^\d]+)(\d+)/',
                    function ($matches) use ($pair) {
                        return $matches[1] . ($matches[2]+$pair[1]);
                    } ,
                    $rightSn
                );
                $sn = $leftSn . '0' . $rightSn;
                array_pop($openStack);
                return $sn;
            }
        } elseif ($sn[$i] == ']') {
            array_pop($openStack);
        }
    }
    return $sn;
}

function splitSnailNumber(string $sn): string {
    return preg_replace_callback('/[\d]{2,}/', function ($m) {
        $div = $m[0] / 2;
        return '[' . floor($div) . ',' . ceil($div) . ']';
    }, $sn, 1);
}

function addition(array $arr1, array $arr2): array {
    $arr = [$arr1, $arr2];
    $oldStr = json_encode($arr);
    do {
//        echo "OLD: " . $oldStr . "\n";
        $newStr2 = $oldStr;
        do {
            $newStr1 = $newStr2;
            $newStr2 = explodeSnailNumber($newStr1);
        } while ($newStr1 != $newStr2);
//        echo "EXP: " . $newStr2 . "\n";
        $newStr2 = splitSnailNumber($newStr1);
//        echo "SPL: " . $newStr2 . "\n";
        if ($newStr2 == $oldStr) {
            break;
        }
        $oldStr = $newStr2;
    } while (true);
    return json_decode($newStr2);
}

function magnitude(array $arr): int {
    $sum = 0;
    foreach ($arr as $key => $el) {
        if (is_array($el)) {
            $el = magnitude($el);
        }
        $sum += $el * (($key == 0) ? 3 : 2);
    }
    return $sum;
}

$list = [];
foreach ($fileContent as $line) {
    $list[] = json_decode($line, true);
}

$highestMagnitude = 0;
foreach ($list as $arr1) {
    foreach ($list as $arr2) {
        if ($arr1 == $arr2) {
            continue;
        }
        $mag1 = magnitude(addition($arr1, $arr2));
        $mag2 = magnitude(addition($arr2, $arr1));
        $highestMagnitude = max($mag1, $highestMagnitude, $mag2);
    }
}

echo "Highest magnitude: " . $highestMagnitude . "\n";