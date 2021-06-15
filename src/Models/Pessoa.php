<?php

class Pessoa
{
    private int $id;
    private string $cpf;
    private string $email;
    private string $nome;
    private string $escola;
    private string $numTelefone1;
    private string $numTelefone2;

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
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of escola
     */ 
    public function getEscola()
    {
        return $this->escola;
    }

    /**
     * Set the value of escola
     *
     * @return  self
     */ 
    public function setEscola($escola)
    {
        $this->escola = $escola;

        return $this;
    }

    /**
     * Get the value of numTelefone1
     */ 
    public function getNumTelefone1()
    {
        return $this->numTelefone1;
    }

    /**
     * Set the value of numTelefone1
     *
     * @return  self
     */ 
    public function setNumTelefone1($numTelefone1)
    {
        $this->numTelefone1 = $numTelefone1;

        return $this;
    }

    /**
     * Get the value of numTelefone2
     */ 
    public function getNumTelefone2()
    {
        return $this->numTelefone2;
    }

    /**
     * Set the value of numTelefone2
     *
     * @return  self
     */ 
    public function setNumTelefone2($numTelefone2)
    {
        $this->numTelefone2 = $numTelefone2;

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

        $result = $conn->query("
            INSERT INTO pessoa
                (cpf, email, nome, escola, num_telefone_1, num_telefone_2)
            VALUES (
                '{$this->getCpf()}',
                '{$this->getEmail()}',
                '{$this->getNome()}',
                '{$this->getEscola()}',
                '{$this->getNumTelefone1()}',
                '{$this->getNumTelefone2()}'
            )
        ");

        if (!$result) {
            $conn->close();
            return false;
        }

        return true;
    }

    public function getPersonByPersonId($pessoaId)
    {
        return $this->getPerson("pessoa_id", $pessoaId);
    }
    
    public function getPersonByEmail($email)
    {
        return $this->getPerson("email", $email);
    }
    
    public function getPersonByCpf($cpf)
    {
        return $this->getPerson("cpf", $cpf);
    }

    public function getPerson($column, $data)
    {
        $conn = $this->getConnection();

        if ($column === "pessoa_id") {
            $query = "SELECT * FROM pessoa WHERE id = '{$data}'";
        }

        if ($column === "email") {
            $query = "SELECT * FROM pessoa WHERE email = '{$data}'";
        }

        if ($column === "cpf") {
            $query = "SELECT * FROM pessoa WHERE cpf = '{$data}'";
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
        $this->setCpf($obj->cpf);
        $this->setEmail($obj->email);
        $this->setNome($obj->nome);
        $this->setNumTelefone1($obj->num_telefone_1);
        $this->setNumTelefone2($obj->num_telefone_2);

        $conn->close();
        return $this;
    }
}
