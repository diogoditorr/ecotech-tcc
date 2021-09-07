<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\PecasEletronicasController;

$result = PecasEletronicasController::delete($_GET['partId']);

if ($result) {
    header('Location: ../../resources/views/donations.php');
} else {
    header('Location: ../../resources/views/donations.php?error="Não foi possível excluir a peça eletrônica"');
}