<?php

include "../Controllers/PessoasController.php";

if (isset($_POST["emailCpf"]) and $_POST["password"]) {
    if (filter_var($_POST["emailCpf"], FILTER_VALIDATE_EMAIL)) {
        $user = PessoasController::verificarCredenciaisUsuario($_POST["emailCpf"], null, $_POST["password"]);
    } else {
        $user = PessoasController::verificarCredenciaisUsuario(null, $_POST["emailCpf"], $_POST["password"]);
    }

    if (!$user) {
        header("Location: ../../resources/views/sign-in.php?error='Email/cpf ou senha invalida'");
        exit();
    }

    session_start();
    $_SESSION['user_id'] = $user->getPessoaId();
    header("Location: ../../resources/views/explore.php");
}