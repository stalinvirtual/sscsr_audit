<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat as Chat;

require __DIR__ . '/vendor/autoload.php';

include "MyApp/Chat.php";
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080 // You can change the port if needed
);

$server->run();