<?php

function battleship(int $x, int $y, array $coords = [])
{
    $player1Ships = [];
    $ships1 = null;
    $ships2 = null;
    $player2Ships = [];
    $playerTurn = 'Player 1';

    display($x, $y, $coords);

    // prompt
    while (true) {
        if ($playerTurn == 'Player 1') {
            if ($ships1 == null && count($player1Ships) <= 1) {
                if (count($player1Ships) == 1) {
                    $command = readline("Player 1 $> ");
                } else {
                    echo "Player 1, place your 2 ships :" . PHP_EOL;
                    $command = readline("Player 1 $> ");
                }
            } else {
                echo "Player 1, launch your attack :" . PHP_EOL;
                $command = readline("Player 1 $> ");
            }
        } elseif ($playerTurn == 'Player 2') {
            if ($ships2 == null && count($player2Ships) <= 1) {
                if (count($player2Ships) == 1) {
                    $command = readline("Player 2 $> ");
                } else {
                    echo "Player 2, place your 2 ships :" . PHP_EOL;
                    $command = readline("Player 2 $> ");
                }
            } else {
                echo "Player 2, launch your attack :" . PHP_EOL;
                $command = readline("Player 2 $> ");
            }
        }

        switch ($command) {
            case strpos($command, 'query'):
                if ($playerTurn == 'Player 1') {
                    $query = str_replace('query ', '', $command);
                    if (in_array(json_decode($query), $player2Ships)) {
                        echo "Player 1, you touched a boat of player 2 !\n";
                        $player2Ships = removeShip($query, $player2Ships);
                        if (checkIfWon($player2Ships)) {
                            echo "Player 1 win !!\n";
                            break 2;
                        }
                    } else {
                        echo "Player 1, you didn't touch anything.\n";
                    }
                    $playerTurn = 'Player 2';
                } else {
                    $query = str_replace('query ', '', $command);
                    if (in_array(json_decode($query), $player1Ships)) {
                        echo "Player 2, you touched a boat of player 1 !\n";
                        $player1Ships = removeShip($query, $player1Ships);
                        if (checkIfWon($player1Ships)) {
                            echo "Player 2 win !!\n";
                            break 2;
                        }
                    } else {
                        echo "Player 2, you didn't touch anything.\n";
                    }
                    $playerTurn = 'Player 1';
                }
                break;
            case strpos($command, 'add'):
                $add = str_replace('add ', '', $command);
                if ($playerTurn == 'Player 1' && $ships1 == null) {
                    if (in_array(json_decode($add), $player1Ships)) {
                        echo "A cross already exists at this location\n";
                    } else {
                        array_push($player1Ships, json_decode($add));
                        if (count($player1Ships) == 2) {
                            $playerTurn = 'Player 2';
                            $ships1 = 'Set';
                            system('clear');
                        }
                    }
                } elseif ($playerTurn == 'Player 2' && $ships2 == null) {
                    if (in_array(json_decode($add), $player2Ships)) {
                        echo "A cross already exists at this location\n";
                    } else {
                        array_push($player2Ships, json_decode($add));
                        if (count($player2Ships) == 2) {
                            $playerTurn = 'Player 1';
                            $ships2 = 'Set';
                            system('clear');
                        }
                    }
                }
                break;
            case strpos($command, 'remove'):
                $remove = str_replace('remove ', '', $command);
                if ($playerTurn == 'Player 1') {
                    if (in_array(json_decode($remove), $player1Ships)) {
                        $player1Ships = removeShip($remove, $player1Ships);
                    } else {
                        echo "No cross exists at this location\n";
                    }
                } else {
                    if (in_array(json_decode($remove), $player2Ships)) {
                        $player2Ships = removeShip($remove, $player2Ships);
                    } else {
                        echo "No cross exists at this location\n";
                    }
                }
                break;
            case strpos($command, 'display'):
                if ($playerTurn == 'Player 1') {
                    display($x, $y, $player1Ships);
                } elseif ($playerTurn == 'Player 2') {
                    display($x, $y, $player2Ships);
                }
                break;
        }
    }
}

function display($x, $y, $coords)
{
    if ($x !== 0 && $y !== 0) {
        $count = 0;
        for ($i = 0; $i < $y; $i++) {
            for ($j = 0; $j < $x; $j++) {
                echo "+---";
            }
            echo "+\n";
            for ($j = 0; $j < $x; $j++) {
                $count = 0;
                foreach ($coords as $coord) {
                    if (isset($coord[0], $coord[1]) && ($coord[0] == $j && $coord[1] == $i)) {
                        echo '| X ';
                        $count++;
                    }
                }
                if ($count == 0) {
                    echo "|   ";
                }
            }
            echo "|\n";
        }
        for ($j = 0; $j < $x; $j++) {
            echo "+---";
        }
        echo "+\n";
    }
}

function removeShip($ship, $ships)
{
    if (in_array(json_decode($ship), $ships) && ($key = array_search(json_decode($ship), $ships)) !== false) {
        unset($ships[$key]);
        return $ships;
    }
}

function checkIfWon($ships)
{
    if (count($ships) == 0) {
        return true;
    }
}

if (isset($argv[1], $argv[2])) {
    battleship($argv[1], $argv[2], []);
} else {
    echo "Arguments missing, call should look like :\n";
    echo "php colle.php <x> <y>\n";
}
