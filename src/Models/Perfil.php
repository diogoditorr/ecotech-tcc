<?php

namespace Models;

use ConexaoDB;

class Perfil
{
    private int $id;
    private int $pessoaId;
    private string $cpf;
    private string $email;
    private string $nomeUsuario;
    private string $senha;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pessoaId
     */ 
    public function getPessoaId()
    {
        return $this->pessoaId;
    }

    /**
     * Set the value of pessoaId
     *
     * @return  self
     */ 
    public function setPessoaId($pessoaId)
    {
        $this->pessoaId = $pessoaId;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of nomeUsuario
     */ 
    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }

    /**
     * Set the value of nomeUsuario
     *
     * @return  self
     */ 
    public function setNomeUsuario($nomeUsuario)
    {
        $this->nomeUsuario = $nomeUsuario;

        return $this;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */ 
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return ConexaoDB::conectar();
    }

    private static function unserialize(\stdClass $object): Perfil
    {
        return (new Perfil())
                    ->setId($object->id)
                    ->setPessoaId($object->pessoa_id)
                    ->setCpf($object->cpf)
                    ->setEmail($object->email)
                    ->setNomeUsuario($object->nome_usuario)
                    ->setSenha($object->senha);
    }
    
    private static function get($column, $data)
    {
        $conn = Perfil::getConnection();
        $query = "SELECT * FROM perfil WHERE {$column} = '{$data}'";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $obj = $result->fetch_object();

        if ($obj === null) {
            $conn -> close();
            return null;
        }

        $profile = Perfil::unserialize($obj);

        $conn->close();
        return $profile;
    }

    public static function getByPersonId($pessoaId)
    {
        return Perfil::get("pessoa_id", $pessoaId);
    }
    
    public static function getByCpf($cpf)
    {
        return Perfil::get("cpf", $cpf);
    }
    
    public static function getByEmail($email)
    {
        return Perfil::get("email", $email);
    }

    public function inserir(): bool
    {
        $conn = Perfil::getConnection();

        $query = "
            INSERT INTO perfil 
                (pessoa_id, cpf, email, nome_usuario, senha)
            VALUES (
                '{$this->getPessoaId()}',
                '{$this->getCpf()}',
                '{$this->getEmail()}',
                '{$this->getNomeUsuario()}',
                '{$this->getSenha()}'
            )
        ";

        $conn->query($query) or
            trigger_error("
                Query Failed! SQL: $query - Error: ". mysqli_error($conn), 
                E_USER_ERROR
            );

        $conn->close();

        return true;
    }
    
    public static function verificarCredenciaisUsuario($cpf, $email, $password)
    {
        $conn = Perfil::getConnection();

        $result = $conn->query("
            SELECT * FROM perfil 
            WHERE 
                (cpf = '{$cpf}' OR email = '{$email}') AND 
                senha = '{$password}'
        ");

        if (!$result) {
            $conn->close();
            return false;
        }

        $obj = $result->fetch_object();

        if ($obj === null) {
            $conn -> close();
            return false;
        }

        $profile = Perfil::unserialize($obj);

        $conn->close();

        return $profile;
    }


    public static function hasDataAlreadyRegistered(string $cpf, string $email, string $username)
    {
        $conn = Perfil::getConnection();

        $result = $conn->query("
            SELECT * FROM perfil
            WHERE 
                cpf = '{$cpf}' OR
                email = '{$email}' OR
                nome_usuario = '{$username}' 
            ;
        ");

        if ($result->num_rows > 0) {
            $conn->close();
            return true;
        }
        
        $conn->close();
        return false;
    }
}
