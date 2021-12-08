<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$sumDigitsOutput = 0;

foreach ($fileContent as $line) {
    [$connections, $digits] = explode(" | ", $line);
    $digits = explode(" ", $digits);
    preg_match_all("/(\b[a-g]{2}\b)|(\b[a-g]{3}\b)|(\b[a-g]{4}\b)|(\b[a-g]{5}\b)|(\b[a-g]{6}\b)/", $connections, $matches);
    $elements = [];
    for ($i = 1; $i <= 5; $i++) {
        $elements[$i-1] = array_filter($matches[$i]);
    }

    $numberOne = reset($elements[0]);
    $numberSeven = reset($elements[1]);
    $numberFour = reset($elements[2]);
    $numberEight = "abcdefg";
    $numberThree = null;
    $numberTwoOrFive = [];
    foreach ($elements[3] as $el) {
        preg_match_all("/[$numberOne]/", $el, $matches);
        foreach ($matches as $match) {
            if (count($match) == 2) {
                $numberThree = $el;
            } else {
                $numberTwoOrFive[] = $el;
            }
        }
    }

    $segmentB = null;
    $numberTwo = null;
    $numberFive = null;
    foreach ($numberTwoOrFive as $num) {
        if (preg_match("/[^$numberThree$num]/", $numberFour, $matches)) {
            $segmentB = reset($matches);
            $numberTwo = $num;
        } else {
            $numberFive = $num;
        }
    }

    $numberNine = null;
    $numberSixOrZero = [];
    foreach ($elements[4] as $el) {
        if (!preg_match("/[^$numberFive$numberSeven]/", $el, $matches)) {
            $numberNine = $el;
        } else {
            $numberSixOrZero[] = $el;
        }
    }

    $numberSix = null;
    $numberZero = null;
    foreach ($numberSixOrZero as $num) {
        preg_match_all("/[$numberSeven]/", $num, $matches);
        if (count($matches[0]) === 3) {
            $numberZero = $num;
        } else {
            $numberSix = $num;
        }
    }

    $numbers = [
        '1' => $numberOne,
        '7' => $numberSeven,
        '4' => $numberFour,
        '2' => $numberTwo,
        '3' => $numberThree,
        '5' => $numberFive,
        '0' => $numberZero,
        '6' => $numberSix,
        '9' => $numberNine,
        '8' => $numberEight,
    ];

    $output = "";
    foreach ($digits as $digit) {
        foreach ($numbers as $number => $pattern) {
            if (preg_match("/^[$pattern]+$/", $digit)) {
                $output .= $number;
                break;
            }
        }
    }

    $sumDigitsOutput += (int)$output;
}

var_dump($sumDigitsOutput);