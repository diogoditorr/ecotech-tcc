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
}
