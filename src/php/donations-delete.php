<?php declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\EletronicPartsController;

$result = EletronicPartsController::delete((int) $_GET['eletronicPartId']);

if ($result) {
    header('Location: ../../resources/views/donations.php');
} else {
    header('Location: ../../resources/views/donations.php?error="Não foi possível excluir a peça eletrônica"');
}