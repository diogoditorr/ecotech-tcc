<?php

class Interessado
{
    private int $id;
    private int $pessoaId;
    private int $pecaEletronicaId;

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
     * Get the value of pecaEletronicaId
     */ 
    public function getPecaEletronicaId()
    {
        return $this->pecaEletronicaId;
    }

    /**
     * Set the value of pecaEletronicaId
     *
     * @return  self
     */ 
    public function setPecaEletronicaId($pecaEletronicaId)
    {
        $this->pecaEletronicaId = $pecaEletronicaId;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return ConexaoDB::conectar();
    }
}