<?php

// EXAMPLE
$target = [
    'x1' => 20,
    'x2' => 30,
    'y1' => -10,
    'y2' => -5,
];

// INPUT
//$target = [
//    'x1' => 281,
//    'x2' => 311,
//    'y1' => -74,
//    'y2' => -54,
//];

function shoot($posX, $posY, $velX, $velY, $target) {
    $highestY = $posY;
    $step = 0;
    $target['left'] = min($target['x1'], $target['x2']);
    $target['right'] = max($target['x1'], $target['x2']);
    $target['up'] = max($target['y1'], $target['y2']);
    $target['bottom'] = min($target['y1'], $target['y2']);
    while ($posX <= $target['right'] && $posY >= $target['bottom']) {
        $step++;
        $posX += $velX;
        $posY += $velY;
        if ($velX > 0) $velX--;
        elseif ($velX < 0) $velX++;
        $velY--;
        if ($posY > $highestY) {
            $highestY = $posY;
        }
        if ($posX >= $target['left'] && $posX <= $target['right'] &&
            $posY <= $target['up'] && $posY >= $target['bottom']) {
            return [true, $highestY, $step];
        }
    }
    return [false, $highestY, $step];
}

$highest = [
    'x' => null,
    'y' => null,
    'maxy' => null,
];
for ($x = 1; $x < 200; $x++) {
    for ($y = 1; $y < 200; $y++) {
        [$success, $maxY, $step] = shoot(0,0,$x,$y,$target);
        if ($success && $maxY > $highest['maxy']) {
            $highest['x'] = $x;
            $highest['y'] = $x;
            $highest['maxy'] = $maxY;
            $highest['step'] = $step;
        }
    }
}

var_dump($highest);