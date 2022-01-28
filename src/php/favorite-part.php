<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\InteressadosController;

if (preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../../resources/views/index.php");
}

if (InteressadosController::isPartFavorited($_POST['partId'], $_SESSION['user_id'])) {
    $result = InteressadosController::unfavoritePart($_POST['partId'], $_SESSION['user_id']);
} else {
    $result = InteressadosController::favoritePart($_POST['partId'], $_SESSION['user_id']);
}

echo "ok";