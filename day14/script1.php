<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = array_filter(explode("\n", file_get_contents('input.txt')));

$template = null;
$rules = [];
foreach ($fileContent as $line) {
    if (preg_match('/(\w+)\s->\s(\w+)/', $line, $matches)) {
        $rules[$matches[1]] = $matches[2];
    } elseif (preg_match('/^(\w+)$/', $line, $matches)) {
        $template = $matches[1];
    }
}

for ($x = 0; $x < 10; $x++) {
    $newTemplate = "";
    for ($i = 0; $i < strlen($template); $i++) {
        $pair = substr($template, $i, 2);
        if (isset($rules[$pair])) {
            $newTemplate .= $pair[0] . $rules[$pair];
        } else {
            $newTemplate .= $pair;
        }
    }
    $template = $newTemplate;
}

$countChars = array_count_values(str_split($template));
rsort($countChars);

$countMostChar = reset($countChars);
$countLeastChar = end($countChars);

var_dump($countMostChar, $countLeastChar, $countMostChar - $countLeastChar, strlen($template));
