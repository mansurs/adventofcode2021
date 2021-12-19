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

$prevArr = json_decode(array_shift($fileContent), true);
while ($line = array_shift($fileContent)) {
    $arr = json_decode($line, true);
    $prevArr = addition($prevArr, $arr);
    echo "---: " . json_encode($prevArr) . "\n";
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

echo "Magnitude: " . magnitude($prevArr) . "\n";