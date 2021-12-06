<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = explode("\n", file_get_contents('input.txt'));

$laternfishes = explode(",", reset($fileContent));

for ($i = 0; $i < 80; $i++) {
    foreach ($laternfishes as $key => $fish) {
        if ($fish == 0) {
            $laternfishes[$key] = 6;
            $laternfishes[] = 8;
        } else {
            $laternfishes[$key]--;
        }
    }
}

echo "num: " . count($laternfishes) . "\n";
//echo implode(",", $laternfishes) . "\n";
