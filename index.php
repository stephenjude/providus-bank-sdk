<?php

require_once __DIR__.'/ProvidusWebhook.php';

use Providus\ProvidusWebhook;

if (isset($_SERVER['HTTP_X_AUTH_SIGNATURE'], $_SERVER['HTTP_CLIENT_ID'])) {
    $data = json_decode(file_get_contents('php://input'), true);

    $headers = $_SERVER;

    $providus = new ProvidusWebhook($headers, $data);

    $response = $providus->verifyTransaction();

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($response);
} else {
    echo "Greenlite: Providus Settlement Webhook";
}

