<?php

declare(strict_types=1);

require 'vendor/autoload.php';
require 'src/sendMessage.php';
require 'src/Todo.php';

$db = new Todo();

$token = "7031918736:AAG3rETeqWfT5oR0M7q1f8aMN_KSDtfI4r0";
$bot = new Bot($token);

$update = json_decode(file_get_contents('php://input'));

if (isset($update) && isset($update->message)) {
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    if ($text === '/start') {
        $bot->sendStart($chat_id);
        return;
    }

    if ($text === '/add') {
        $db->saveAddTask('add');
        $bot->sendAdd($chat_id);
        return;
    }

    if ($text === '/all') {
        $todos = $db->AllTodo();
        $bot->sendAll($chat_id, $todos);
        return;
    }
}

if (isset($text)) {

    $add = $db->getAddTask();
    if ($add[0]['addtask'] == 'add') {
        $db->sendAddTask($text);
        $db->deleteAddTask();
        return;
    }

}
require 'view.php';

