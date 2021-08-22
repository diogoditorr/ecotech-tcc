<?php

namespace Controllers;

use Models\Pessoa;
use Models\Perfil;
use Models\Endereco;

class PessoasController 
{
    public static function registrarUsuario(array $data)
    {
        $dataAlreadyRegistered = Perfil::hasDataAlreadyRegistered($data['cpf'], $data['email'], $data['username']);

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
            $pessoaId = Pessoa::getByCpf($data['cpf'])->getId();

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
            $profile = Perfil::getByPersonId($pessoaId);

        } else if ($cpf) {
            $profile = Perfil::getByCpf($cpf);
            
        } else if ($email) {
            $profile = Perfil::getByEmail($email);
        }

        return $profile;
    }

    public static function verificarCredenciaisUsuario($cpf, $email, $password) 
    {
        return Perfil::verificarCredenciaisUsuario($cpf, $email, $password);
    }

    public static function getByPersonId(int $personId)
    {
        return Pessoa::getById($personId);
    }
}