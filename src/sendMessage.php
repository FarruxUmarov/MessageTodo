<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Bot {
    private $client;
    private $tgApi;

    public function __construct(string $token) {
        $this->tgApi = "https://api.telegram.org/bot$token/";
        $this->client = new Client(['base_uri' => $this->tgApi]);
    }

    public function sendStart(int $chat_id) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => "Welcome to Todo app"
            ]
        ]);
    }

    public function sendAdd(int $chat_id) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => "Enter the task"
            ]
        ]);
    }

    public function sendAll(int $chat_id, array $todos) {
        $todoText = "Your Todo List:\n";
        foreach ($todos as $todo) {
            $status = $todo['status'];
            $text = $todo['status'] ? "<s>{$todo['text']}</s>" : $todo['text'];
            $todoText .= "{$status} {$text}\n";
        }
    
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $todoText,
                'parse_mode' => 'HTML'
            ]
        ]);
    }


    
}
