<?php declare(strict_types=1);

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
    // 'eletronicPart' => [
    //     'id' => $eletronicPart->getId(),
    //     'person' => [
    //         'id' => $eletronicPart->getPessoaId(),
    //         'name' => $person->getNome(),
    //         'email' => $person->getEmail(),
    //         'phoneNumber1' => $person->getNumTelefone1(),
    //         'phoneNumber2' => $person->getNumTelefone2(),
    //         'address' => [
    //             'state' => $person->getEndereco()->getEstado(),
    //             'city' => $person->getEndereco()->getCidade(),
    //             'neighborhood' => $person->getEndereco()->getBairro(),
    //             'cep' => $person->getEndereco()->getCep()
    //         ]
    //     ],
    //     'name' => $eletronicPart->getNome(),
    //     'type' => $eletronicPart->getTipo(),
    //     'model' => $eletronicPart->getModelo(),
    //     'description' => $eletronicPart->getSobre(),
    //     'image' => $eletronicPart->getImagem()->name,
    //     'stock' => $eletronicPart->getEstoque(),
    //     'isFavorited' => InterestedController::iseletronicPartFavorited($eletronicPart->getId(), $_SESSION['user_id'])
    // ]
    'eletronicPart' => array_merge(
        $eletronicPart->toArray(),
        ['person' => $person->toArray()],
        ['isFavorited' => InterestedController::iseletronicPartFavorited($eletronicPart->getId(), $_SESSION['user_id'])]
    )
]);
