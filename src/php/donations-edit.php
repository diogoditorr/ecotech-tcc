<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\PecasEletronicasController;
// use Classes\Image;

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../../resources/views/index.php");
}

// Verify if all data is filled in
if (empty($_FILES['image']['name'])) {
    $imageInfo = null;
} else {
    $imageInfo = $_FILES['image'];
}

$result = PecasEletronicasController::editarPeca($_POST + ['image' => $imageInfo]);

if ($result['success']) {
    header("Location: ../../resources/views/donations.php");
} else {
    header(
        "Location: ../../resources/views/donations-edit.php?".
            "peca_id={$_POST['id']}&error={$result['error']}"
    );
}