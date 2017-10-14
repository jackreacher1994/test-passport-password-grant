<?php

require "vendor/autoload.php";

$client = new GuzzleHttp\Client;

try {
    $response = $client->post('http://localhost/testpassport/server/oauth/token', [
        'form_params' => [
            'client_id' => 2,
            'client_secret' => 'UJnsVAnAMJATvfGZza5Vky3nlisS1qQYn7fkk4QH',
            'grant_type' => 'password',
            'username' => 'jackreacher@gmail.com',
            'password' => 'secret',
            'scope' => '*',
        ]
    ]);

    // You'd typically save this payload in the session
    $auth = json_decode( (string) $response->getBody() );

    $response = $client->get('http://localhost/testpassport/server/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->access_token,
        ]
    ]);

    $todos = json_decode( (string) $response->getBody() );

    $todoList = "";
    foreach ($todos as $todo) {
        $todoList .= "<li>{$todo->task} ".($todo->done ? 'V' : '')."</li>";
    }

    echo "<ul>{$todoList}</ul>";

} catch (GuzzleHttp\Exception\BadResponseException $e) {
    echo "Unable to retrieve access token.";
}
