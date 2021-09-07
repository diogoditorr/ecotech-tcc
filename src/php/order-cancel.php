<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\PedidosController;

header('Content-Type: application/json');

$result = PedidosController::changeStatus($_POST['orderId'], 'cancelado');

echo json_encode([
    'success' => $result
]);