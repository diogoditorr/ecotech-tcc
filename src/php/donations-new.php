<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\PecasEletronicasController;
// use Classes\Image;

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../../resources/views/index.php");
}

// Verify if all data is filled in
if (empty($_FILES['image'])) {
    throw new \Exception('No image file');
}

$result = PecasEletronicasController::registrarPeca($_POST + $_FILES);

if ($result['success']) {
    header("Location: ../../resources/views/donations.php");
} else {
    header("Location: ../../resources/views/donations-new.php");
}