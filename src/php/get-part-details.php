<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\InterestedController;
use App\Controllers\EletronicPartsController;
use App\Controllers\PeopleController;

session_start();

header('Content-Type: application/json');

if (preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

if (!isset($_POST['eletronicPartId'])) {
    echo json_encode(['error' => 'Missing partId']);
    exit();
}

$eletronicPart = EletronicPartsController::getById($_POST['eletronicPartId']);
$person = PeopleController::getById($eletronicPart->getPersonId());

echo json_encode([
    'eletronicPart' => [
        ...$eletronicPart
            ->makeHidden(['personId', 'personIdName'])
            ->toArray(),
        'person' => $person->toArray(),
        'isFavorited' => 
            InterestedController::isEletronicPartFavorited(
                $eletronicPart->getId(),
                $_SESSION['user_id']
            )
    ]
]);
