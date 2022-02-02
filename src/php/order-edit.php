<?php declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\OrdersController;

header('Content-Type: application/json');

$result = OrdersController::changeStatus($_POST['orderId'], $_POST['status']);

echo json_encode([
    'success' => $result
]);
