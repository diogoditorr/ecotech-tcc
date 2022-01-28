<?php

namespace Models;

use ConexaoDB;
use Models\BaseModel;

class Endereco extends BaseModel
{
    protected int $id;
    protected int $pessoaId;
    protected string $estado;
    protected string $cidade;
    protected string $bairro;
    protected string $cep;

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
     * Get the value of estado
     */ 
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */ 
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of cidade
     */ 
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @return  self
     */ 
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of bairro
     */ 
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set the value of bairro
     *
     * @return  self
     */ 
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get the value of cep
     */ 
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @return  self
     */ 
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return ConexaoDB::conectar();
    }

    private static function fromArray(array $data)
    {
        return (new Endereco())
                    ->setPessoaId($data["pessoa_id"])
                    ->setEstado($data["estado"])
                    ->setCidade($data["cidade"])
                    ->setBairro($data["bairro"])
                    ->setCep($data["cep"]);
    }

    public function inserir(): bool
    {
        $conn = Endereco::getConnection();

        $query = "
            INSERT INTO endereco 
                (pessoa_id, estado, cidade, bairro, cep)
            VALUES (
                '{$this->getPessoaId()}',
                '{$this->getEstado()}',
                '{$this->getCidade()}',
                '{$this->getBairro()}',
                '{$this->getCep()}'
            )
        ";

        $conn->query($query) or 
            trigger_error("
                Query Failed! SQL: $query - Error: ". mysqli_error($conn), 
                E_USER_ERROR
            );

        return true;
    }
}