<?php declare(strict_types=1);

use App\Controllers\PeopleController;

require_once __DIR__ . "/../../vendor/autoload.php";

if (!$_POST['password'] === $_POST['passwordConfirm']) {
    header("Location: ../../resources/views/sign-up.php?error=\"As senhas não coincidem\"");
    exit();
}

$result = PeopleController::registerUser($_POST);

if (!$result['success']) {
    header("Location: ../../resources/views/sign-up.php?error=\"{$result['error']}\"");
    exit();
} 

$profile = PeopleController::loadProfile(email: $_POST['email']);

session_start();
$_SESSION['user_id'] = $profile->getPersonId();
$_SESSION['user_username'] = $profile->getUserName();

header("Location: ../../resources/views/explore.php");