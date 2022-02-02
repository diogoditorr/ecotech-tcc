<?php declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\InterestedController;

if (preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../../resources/views/index.php");
}

if (InterestedController::isEletronicPartFavorited($_POST['eletronicPartId'], $_SESSION['user_id'])) {
    InterestedController::unfavoriteEletronicPart($_POST['eletronicPartId'], $_SESSION['user_id']);
} else {
    InterestedController::favoriteEletronicPart($_POST['eletronicPartId'], $_SESSION['user_id']);
}