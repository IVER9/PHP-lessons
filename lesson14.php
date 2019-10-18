<?php

// 40 じゃんけんを作成しよう！
// 下記の要件を満たす「じゃんけんプログラム」を開発してください。
//
// 要件定義
// ・使用可能な手はグー、チョキ、パー
// ・勝ち負けは、通常のじゃんけん
// ・PHPファイルの実行はコマンドラインから。
//
// ご自身が自由に設計して、プログラムを書いてみましょう！

const HANDS = ['グー', 'チョキ', 'パー'];          //じゃんけんの配列を定数化にしました。

play();

function play() {
    echo '最初はグー!' . PHP_EOL;
    echo 'じゃんけんポン！！' . PHP_EOL;
    janken();
    replay();                                      //じゃんけんを続けられるようにしました。
}

function janken() {                                 //じゃんけん
    $userHand = userHandType();                     //あなたのハンド
    $cpuHand = cpuHandType();                       //コンピューターのハンド
    $result = jankenResult($userHand, $cpuHand);    //結果
    if (!$result) {                                 //結果があいこなら繰り返す。
        return janken();
    }
}

function replay() {                                 //再プレイ
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

function userHandType() {                           //ユーザーのハンドを決める
    echo '0:グー, 1:チョキ, 2:パー' . PHP_EOL;
    $input = trim(fgets(STDIN));                //ハンドを入力。
    $check = checkMyhand($input);               //ハンドのバリデーションチェック
    if (!$check) {                              //バリデーションチェックがエラーの場合、入力し直しさせる。
        return userHandType();
    }
    echo HANDS[$input] . PHP_EOL;
    return $input;                            //入力結果を返す
}

function cpuHandType() {                      //コンピューターのハンドを決める
    $hand = mt_rand(0, 2);                    //ランダムでハンドを決定
    echo HANDS[$hand] . PHP_EOL;
    return $hand;                             //コンピューターのハンドを返す
}

function jankenResult($userHand, $cpuHand) {              //じゃんけん結果
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

function checkMyhand($input) {                                  //ユーザーのハンド入力のバリデーションチェック
    $errors = array();
    if ($input === '') {
        $errors[] = '未入力です' . PHP_EOL;
    }

    if (ctype_digit(strval($input)) === false) {
        $errors[] = '整数を入力してください。' . PHP_EOL;
    }

    if (!($input <=2)) {
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
