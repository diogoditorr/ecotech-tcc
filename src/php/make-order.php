<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\PedidosController;

session_start();

$result = PedidosController::fazerPedido($_POST);

if (!$result['success'])
    header('Location: ../../resources/views/explore.php?error="' . $result['error']). '"';

header('Location: ../../resources/views/orders.php');