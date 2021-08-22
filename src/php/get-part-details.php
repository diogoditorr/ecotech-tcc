<?php

require __DIR__.'/../../vendor/autoload.php';

use Controllers\PecasEletronicasController;
use Controllers\PessoasController;

session_start();

header('Content-Type: application/json');

if (preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

if (!isset($_POST['partId'])) {
    echo json_encode(['error' => 'Missing partId']);
    exit();
}

$part = PecasEletronicasController::getById($_POST['partId']);
$person = PessoasController::getByPersonId($part->getPessoaId());

echo json_encode([
    'part' => [
        'id' => $part->getId(),
        'person' => [
            'id' => $part->getPessoaId(),
            'name' => $person->getNome(),
            'email' => $person->getEmail(),
            'phoneNumber1' => $person->getNumTelefone1(),
            'phoneNumber2' => $person->getNumTelefone2(),
            'address' => [
                'state' => $person->getEndereco()->getEstado(),
                'city' => $person->getEndereco()->getCidade(),
                'neighborhood' => $person->getEndereco()->getBairro(),
                'cep' => $person->getEndereco()->getCep()
            ]
        ],
        'name' => $part->getNome(),
        'type' => $part->getTipo(),
        'model' => $part->getModelo(),
        'description' => $part->getSobre(),
        'image' => $part->getImagem()->name,
        'stock' => $part->getEstoque()
    ]
]);
