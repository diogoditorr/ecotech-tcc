<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\PeopleController;

if (
    isset($_SERVER['CONTENT_TYPE']) &&
    preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])
) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

if (!isset($_POST["emailCpf"]) || !isset($_POST["password"])) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha não preenchidos!'");
    // http_response_code(400);
    exit();
}

$profile = null;
if (filter_var($_POST["emailCpf"], FILTER_VALIDATE_EMAIL)) {
    if (PeopleController::verifyUserCredentials(
        email: $_POST["emailCpf"],
        password: $_POST["password"]
    ))
        $profile = PeopleController::loadProfile(email: $_POST["emailCpf"]);
} else {
    if (PeopleController::verifyUserCredentials(
        cpf: $_POST["emailCpf"],
        password: $_POST["password"]
    ))
        $profile = PeopleController::loadProfile(cpf: $_POST["emailCpf"]);
}

if ($profile === null) {
    // http_response_code(400);
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha invalida'");
    exit();
}

session_start();
$_SESSION['user_id'] = $profile->getPersonId();
$_SESSION['user_username'] = $profile->getUserName();

header("Location: ../../resources/views/explore.php");
