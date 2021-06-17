<?php

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

    public function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return (new ConexaoDB())->conectar();
    }

    public function inserir(): bool
    {
        $conn = $this->getConnection();

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

        return true;
    }
    
    public function verificarCredenciaisUsuario($cpf, $email, $password)
    {
        $conn = $this->getConnection();

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

        $this->setId($obj->id);
        $this->setPessoaId($obj->pessoa_id);
        $this->setEmail($obj->email);
        $this->setCpf($obj->cpf);
        $this->setNomeUsuario($obj->nome_usuario);
        $this->setSenha($obj->senha);

        $conn->close();

        return $this;
    }

    public function getProfileByPersonId($pessoaId)
    {
        return $this->getProfile("pessoa_id", $pessoaId);
    }
    
    public function getProfileByCpf($cpf)
    {
        return $this->getProfile("cpf", $cpf);
    }
    
    public function getProfileByEmail($email)
    {
        return $this->getProfile("email", $email);
    }

    public function getProfile($column, $data)
    {
        $conn = $this->getConnection();

        if ($column === "pessoa_id") {
            $query = "SELECT * FROM perfil WHERE pessoa_id = '{$data}'";
        }
        
        if ($column === "cpf") {
            $query = "SELECT * FROM perfil WHERE cpf = '{$data}'";
        }

        if ($column === "email") {
            $query = "SELECT * FROM perfil WHERE email = '{$data}'";
        }

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

        $this->setId($obj->id);
        $this->setPessoaId($obj->pessoa_id);
        $this->setCpf($obj->cpf);
        $this->setEmail($obj->email);
        $this->setNomeUsuario($obj->nome_usuario);
        $this->setSenha($obj->senha);

        $conn->close();
        return $this;
    }

    public function hasDataAlreadyRegistered($cpf, $email, $username)
    {
        $conn = $this->getConnection();

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
