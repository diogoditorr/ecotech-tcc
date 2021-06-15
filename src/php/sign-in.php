<?php

include "../Controllers/PessoasController.php";

if (!isset($_POST["emailCpf"]) || !isset($_POST["password"])) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha não preenchidos!'");
    exit();
} 

if (filter_var($_POST["emailCpf"], FILTER_VALIDATE_EMAIL)) {
    $user = PessoasController::verificarCredenciaisUsuario(null, $_POST["emailCpf"], $_POST["password"]);
} else {
    $user = PessoasController::verificarCredenciaisUsuario($_POST["emailCpf"], null, $_POST["password"]);
}

if (!$user) {
    header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha invalida'");
    exit();
}

session_start();
$_SESSION['user_id'] = $user->getPessoaId();
$_SESSION['user_username'] = $user->getNomeUsuario();
header("Location: ../../resources/views/explore.php");