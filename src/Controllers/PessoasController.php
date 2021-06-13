<?php

include "../Models/Perfil.php";

class PessoasController 
{
    public static function verificarCredenciaisUsuario($email, $cpf, $password) 
    {
        return (new Perfil())->verificarCredenciaisUsuario($email, $cpf, $password);
    }
}