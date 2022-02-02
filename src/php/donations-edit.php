<?php declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\EletronicPartsController;

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

$result = EletronicPartsController::edit($_POST + ['image' => $imageInfo]);

if ($result['success']) {
    header("Location: ../../resources/views/donations.php");
} else {
    header(
        "Location: ../../resources/views/donations-edit.php?".
            "eletronicPartId={$_POST['id']}&error={$result['error']}"
    );
}