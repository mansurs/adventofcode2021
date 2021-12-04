<?php

//$fileContent = explode("\n", file_get_contents('example.txt'));
$fileContent = explode("\n", file_get_contents('input.txt'));

$bingoInput = explode(",", array_shift($fileContent));

// ignore second line, as it's empty
array_shift($fileContent);

$boards = [];
$board = [];

//var_dump($fileContent);

foreach ($fileContent as $line) {
    if (preg_match_all("/[\d]+/", $line, $numbers) > 0) {
        $board[] = array_fill_keys($numbers[0], 0);
    } elseif ($board) {
        $boards[] = $board;
        $board = [];
    }
}

if ($board) {
    $boards[] = $board;
    $board = [];
}

function boardIsBingo(array $board) {
    $columns = count(reset($board));
    foreach ($board as $row) {
        if (array_sum($row) === count($row)) {
            return $row;
        }
    }
    for ($i = 0; $i < $columns; $i++) {
        $column = [];
        $columnMarks = [];
        foreach ($board as $row) {
            $number = array_slice($row, $i, 1, true);
            $column[] = array_keys($number)[0];
            $columnMarks[] = reset($number);
        }
        if (array_sum($columnMarks) === count($columnMarks)) {
            return $column;
        }
    }
    return false;
}

function getBoardUnmarkedSum($board) {
    $sumUnmarked = 0;
    foreach ($board as $row) {
        $sumUnmarked += array_sum(
            array_keys(
                array_filter(
                $row,
                function ($v, $k) { return !$v;},
                ARRAY_FILTER_USE_BOTH)
            )
        );
    }
    return $sumUnmarked;
}

$boardsWon = [];

foreach($bingoInput as $number) {
    foreach ($boards as $boardNumber => $board) {
        foreach ($board as $rowNumber => $row) {
            if (array_key_exists($number, $row)) {
                $boards[$boardNumber][$rowNumber][$number] = 1;
            }
        }
    }
    foreach ($boards as $boardNumber => $board) {
        if (array_key_exists($boardNumber, $boardsWon)) {
            continue;
        }
        $numbers = boardIsBingo($board);
        if ($numbers) {
            $boardsWon[$boardNumber] = true;

            if (count($boardsWon) == count($boards)) {
                $sumUnmarked = getBoardUnmarkedSum($board);
                echo "Last board after $number on board $boardNumber with " . implode(",", array_keys($numbers)) . "\n";
                echo "Sum: $sumUnmarked; Finally: " . ($sumUnmarked * $number) . "\n";
                exit();
            }
        }
    }
}


