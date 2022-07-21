<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\OrdersController;

session_start();

$result = OrdersController::requestOrder(
    eletronicPartId: (int) $_POST['eletronicPartId'],
    donorId: (int) $_POST['donorId'],
    receiverId: (int) $_SESSION['user_id']
);

if (!$result['success'])
    header('Location: ../../resources/views/explore.php?error="' . $result['error']) . '"';

header('Location: ../../resources/views/orders.php');
