<?php

class Pedido
{
    private string $id;
    private int $pecaEletronicaId;
    private string $doardorId;
    private string $clienteId;
    private string $status;
    private string $created_at;

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

    /**
     * Get the value of doardorId
     */ 
    public function getDoardorId()
    {
        return $this->doardorId;
    }

    /**
     * Set the value of doardorId
     *
     * @return  self
     */ 
    public function setDoardorId($doardorId)
    {
        $this->doardorId = $doardorId;

        return $this;
    }

    /**
     * Get the value of clienteId
     */ 
    public function getClienteId()
    {
        return $this->clienteId;
    }

    /**
     * Set the value of clienteId
     *
     * @return  self
     */ 
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return ConexaoDB::conectar();
    }
}