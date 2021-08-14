<?php

namespace Models;

use Models\Imagem;

class PecaEletronica
{
    private int $id;
    private int $pessoaId;
    private string $nome;
    private string $tipo;
    private string $modelo;
    private string $sobre;
    private Imagem|null $imagem;
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

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";

        return \ConexaoDB::conectar();
    }

    private static function fromArray(array $object): PecaEletronica
    {
        return (new PecaEletronica())
            ->setId($object['id'])
            ->setPessoaId($object['pessoa_id'])
            ->setNome($object['nome'])
            ->setTipo($object['tipo'])
            ->setModelo($object['modelo'])
            ->setSobre($object['sobre'])
            ->setImagem(Imagem::createByName($object['imagem']))
            ->setEstoque($object['estoque']);
    }

    private function storageImage()
    {
        $directory = __DIR__ . "/../../storage/parts/";

        if (!move_uploaded_file($this->imagem->tmpNamePath, $directory.$this->imagem->getNameFormatted())) {
            throw new \Exception("Failed to upload image");
        }
    }

    public function inserir()
    {
        $this->storageImage();

        $connection = PecaEletronica::getConnection();
        $query = "
            INSERT INTO peca_eletronica 
                (pessoa_id, nome, tipo, modelo, sobre, imagem, estoque) 
            VALUES (
                {$this->getPessoaId()}, 
                '{$this->getNome()}', 
                '{$this->getTipo()}', 
                '{$this->getModelo()}', 
                '{$this->getSobre()}', 
                '{$this->getImagem()->getNameFormatted()}',
                {$this->getEstoque()}
            )
        ";

        $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $connection->close();

        return true;
    }

    public static function getById(int $pecaId)
    {
        $conn = PecaEletronica::getConnection();
        $query = "SELECT * FROM peca_eletronica WHERE id = {$pecaId}";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $obj = $result->fetch_assoc();

        if ($obj === null) {
            $conn->close();
            return null;
        }

        $pecaEletronica = PecaEletronica::fromArray($obj);

        $conn->close();
        return $pecaEletronica;
    }

    public static function buscarPecas(int $userId): array
    {
        $connection = PecaEletronica::getConnection();
        $query = "SELECT * FROM peca_eletronica WHERE pessoa_id = {$userId}";

        $result = $connection->query($query) or
            trigger_error(
                "
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $pecasEletronicas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row !== null) {
                \array_push($pecasEletronicas, PecaEletronica::fromArray($row));
            }
        }

        return $pecasEletronicas;
    }

    public function editarPeca()
    {
        $connection = PecaEletronica::getConnection();

        if ($this->getImagem() != null) {
            $this->storageImage();

            $query = "
                UPDATE peca_eletronica 
                SET 
                    nome = '{$this->getNome()}', 
                    tipo = '{$this->getTipo()}', 
                    modelo = '{$this->getModelo()}', 
                    sobre = '{$this->getSobre()}', 
                    imagem = '{$this->getImagem()->getNameFormatted()}', 
                    estoque = {$this->getEstoque()} 
                WHERE 
                    id = {$this->getId()}
            ";   
        } else {
            $query = "
                UPDATE peca_eletronica 
                SET 
                    nome = '{$this->getNome()}', 
                    tipo = '{$this->getTipo()}', 
                    modelo = '{$this->getModelo()}', 
                    sobre = '{$this->getSobre()}', 
                    estoque = {$this->getEstoque()} 
                WHERE 
                    id = {$this->getId()}
            ";
        }

        $connection->query($query) or
            trigger_error("
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $connection->close();
        return true;
    }
}
