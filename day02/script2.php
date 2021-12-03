<?php

$commands = array_filter(explode("\n", file_get_contents('input.txt')));

$horizontal = 0;
$depth = 0;
$aim = 0;

foreach ($commands as $command) {
    preg_match("/([\w]+)\s([\d]+)/", $command, $matches);
    switch ($matches[1]) {
        case "forward":
            $horizontal += (int) $matches[2];
            $depth += ($aim * $matches[2]);
            break;
        case "down":
            $aim += (int) $matches[2];
            break;
        case "up":
            $aim -= (int) $matches[2];
            break;
    }
}

var_dump($horizontal, $depth, $horizontal*$depth);