<?php

$fileContent = explode("\n", file_get_contents('example.txt'));
//$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$countDigits = 0;

foreach ($fileContent as $line) {
    [$connections, $digits] = explode(" | ", $line);
    $digits = explode(" ", $digits);
    foreach ($digits as $digit) {
        switch (mb_strlen($digit)) {
            case 2:
            case 3:
            case 4:
            case 7:
                $countDigits++;
        }
    }
}

var_dump($countDigits);