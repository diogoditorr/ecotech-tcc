<?php

include "../Models/Pessoa.php";
include "../Models/Perfil.php";
include "../Models/Endereco.php";

class PessoasController 
{
    public static function registrarUsuario(array $data)
    {
        $dataAlreadyRegistered = (new Perfil())
            ->hasDataAlreadyRegistered($data['cpf'], $data['email'], $data['username']);

        if ($dataAlreadyRegistered) {
            return array(
                "success" => false,
                "error" => "CPF, email ou nome de usuário já cadastrado"
            );
        }

        $registerPessoaSuccess = (new Pessoa())
            ->setCpf($data['cpf'])
            ->setEmail($data['email'])
            ->setNome($data['fullName'])
            ->setEscola($data['school'])
            ->setNumTelefone1($data['phoneNumber1'])
            ->setNumTelefone2(isset($data['phoneNumber2']) ? $data['phoneNumber2'] : "")
            ->inserir();

        if ($registerPessoaSuccess) {
            $pessoaId = (new Pessoa())->getPersonByCpf($data['cpf'])->getId();

            $registerPerfilSuccess = (new Perfil())
                ->setPessoaId($pessoaId)
                ->setCpf($data['cpf'])
                ->setEmail($data['email'])
                ->setNomeUsuario($data['username'])
                ->setSenha($data['password'])
                ->inserir();

            $registerEnderecoSuccess = (new Endereco())
                ->setPessoaId($pessoaId)
                ->setEstado($data['state'])
                ->setCidade($data['city'])
                ->setBairro($data['district'])
                ->setCep($data['cep'])
                ->inserir();
        }

        if (!$registerPessoaSuccess || !$registerPerfilSuccess || !$registerEnderecoSuccess) {
            return array(
                "success" => false,
                "error" => "Não foi possível registrar no banco de dados"
            );
        }

        return array(
            "success" => true,
            "error" => ""
        );
    }

    public static function carregarPerfil($pessoaId, $cpf, $email)
    {
        $profile = null;

        if ($pessoaId) {
            $profile = (new Perfil())->getProfileByPersonId($pessoaId);

        } else if ($cpf) {
            $profile = (new Perfil())->getProfileByCpf($cpf);
            
        } else if ($email) {
            $profile = (new Perfil())->getProfileByEmail($email);
        }

        return $profile;
    }

    public static function verificarCredenciaisUsuario($cpf, $email, $password) 
    {
        return (new Perfil())->verificarCredenciaisUsuario($cpf, $email, $password);
    }

}