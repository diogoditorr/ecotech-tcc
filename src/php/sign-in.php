<?php

require __DIR__.'/../../vendor/autoload.php';

use Controllers\PessoasController;

if (!isset($_POST["emailCpf"]) || !isset($_POST["password"])) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha não preenchidos!'");
    exit();
} 

$profile = null;
if (filter_var($_POST["emailCpf"], FILTER_VALIDATE_EMAIL)) {
    if (PessoasController::verificarCredenciaisUsuario(null, $_POST["emailCpf"], $_POST["password"]))
        $profile = PessoasController::carregarPerfil(null, null, $_POST["emailCpf"]);

} else {
    if (PessoasController::verificarCredenciaisUsuario($_POST["emailCpf"], null, $_POST["password"]))
        $profile = PessoasController::carregarPerfil(null, $_POST["emailCpf"], null);
}

if ($profile === null) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha invalida'");
    exit();
}

session_start();
$_SESSION['user_id'] = $profile->getPessoaId();
$_SESSION['user_username'] = $profile->getNomeUsuario();

header("Location: ../../resources/views/explore.php");