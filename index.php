<?php

require_once __DIR__.'/ProvidusWebhook.php';

$webhookData = json_decode(file_get_contents("php://input"), true);

if (isset($webhookData['sessionId'])) {
    $response = (new \Providus\ProvidusWebhook())->verifyTransaction($webhookData['sessionId']);

    file_put_contents('php://stdout', $response);
}

echo "Greenlite: Providus Settlement Webhook";
