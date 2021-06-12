<?php

class PecaEletronica
{
    private int $id;
    private int $pessoaId;
    private string $nome;
    private string $tipo;
    private string $modelo;
    private string $sobre;
    private string $imagem;
    private int $estoque;

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
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of modelo
     */ 
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @return  self
     */ 
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of sobre
     */ 
    public function getSobre()
    {
        return $this->sobre;
    }

    /**
     * Set the value of sobre
     *
     * @return  self
     */ 
    public function setSobre($sobre)
    {
        $this->sobre = $sobre;

        return $this;
    }

    /**
     * Get the value of imagem
     */ 
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     *
     * @return  self
     */ 
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get the value of estoque
     */ 
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * Set the value of estoque
     *
     * @return  self
     */ 
    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;

        return $this;
    }

    public function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return (new ConexaoDB())->conectar();
    }
}