<?php

const HANDS = ['グー', 'チョキ', 'パー'];          

play();

function play() {
    echo '最初はグー!' . PHP_EOL;
    echo 'じゃんけんポン！！' . PHP_EOL;
    janken();
    replay();                                      
}

function janken() {                                 
    $userHand = userHandType();                     
    $cpuHand = cpuHandType();                       
    $result = jankenResult($userHand, $cpuHand);   
    if (!$result) {                                 
        return janken();
    }
}

function replay() {                                
    echo 'じゃんけんを続けますか' . PHP_EOL;
    echo '0: 続ける, 1:やめる' . PHP_EOL;
    $input = trim(fgets(STDIN));
    switch ($input) {
        case '0':
            return play();
        case '1':
            return;
        default:
            echo '0, 1を入力してください';
            return replay();
    }
}

function userHandType() {                           
    echo '0:グー, 1:チョキ, 2:パー' . PHP_EOL;
    $input = trim(fgets(STDIN));               
    $check = checkMyhand($input);               
    if (!$check) {                              
        return userHandType();
    }
    echo HANDS[$input] . PHP_EOL;
    return $input;                           
}

function cpuHandType() {                      
    $hand = mt_rand(0, 2);                   
    echo HANDS[$hand] . PHP_EOL;
    return $hand;                           
}

function jankenResult($userHand, $cpuHand) {              
    $result = ($userHand - $cpuHand + 3) % 3;
    switch ($result) {
        case 0:
            echo 'あいこでしょ！！' . PHP_EOL;
            return false;
        case 1:
            echo 'あなたの負けです！！' . PHP_EOL;
            return true;
        case 2:
            echo 'あなたの勝ちです！！' . PHP_EOL;
            return true;
    }
}

function checkMyhand($input) {                                
    $errors = array();
    if ($input === '') {
        $errors[] = '未入力です' . PHP_EOL;
    }

    if (ctype_digit(strval($input)) === false) {
        $errors[] = '整数を入力してください。' . PHP_EOL;
    }

    if (!array_key_exists($input, HANDS)) {
        $errors[] = '[0, 1, 2]を入力してください。' . PHP_EOL;
    }

    if ($errors) {
        foreach ($errors as $error) {
            echo $error . PHP_EOL;
        }
        return false;
    }
    return true;
}

?>
