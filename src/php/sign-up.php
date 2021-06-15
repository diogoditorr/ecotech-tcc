<?php

include "../Controllers/PessoasController.php";

if (!$_POST['password'] === $_POST['passwordConfirm']) {
    header("Location: ../../resources/views/sign-up.php?error=\"As senhas não coincidem\"");
    exit();
}

$result = PessoasController::registrarUsuario($_POST);

if (!$result['success']) {
    header("Location: ../../resources/views/sign-up.php?error=\"{$result['error']}\"");
    exit();
} 

$profile = PessoasController::carregarPerfil(null, null, $_POST['email']);

session_start();
$_SESSION['user_id'] = $profile->getPessoaId();
$_SESSION['user_username'] = $profile->getNomeUsuario();

header("Location: ../../resources/views/explore.php");