<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use App\Controllers\PeopleController;

if (!isset($_POST["emailCpf"]) || !isset($_POST["password"])) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha não preenchidos!'");
    exit();
} 

$profile = null;
if (filter_var($_POST["emailCpf"], FILTER_VALIDATE_EMAIL)) {
    if (PeopleController::verifyUserCredentials(null, $_POST["emailCpf"], $_POST["password"]))
        $profile = PeopleController::loadProfile(null, null, $_POST["emailCpf"]);

} else {
    if (PeopleController::verifyUserCredentials($_POST["emailCpf"], null, $_POST["password"]))
        $profile = PeopleController::loadProfile(null, $_POST["emailCpf"], null);
}

if ($profile === null) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha invalida'");
    exit();
}

session_start();
$_SESSION['user_id'] = $profile->getPersonId();
$_SESSION['user_username'] = $profile->getUserName();

header("Location: ../../resources/views/explore.php");