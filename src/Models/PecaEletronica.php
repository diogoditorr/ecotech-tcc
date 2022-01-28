<?php

namespace Models;

use Models\Imagem;
use Models\BaseModel;

class PecaEletronica extends BaseModel
{
    protected int $id;
    protected int $pessoaId;
    protected string|null $pessoaIdNome;
    protected string|null $nome;
    protected string|null $tipo;
    protected string|null $modelo;
    protected string|null $sobre;
    protected Imagem|null $imagem;
    protected int $estoque;

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
     * Get the value of pessoaIdName
     */ 
    public function getPessoaIdNome()
    {
        return $this->pessoaIdNome;
    }

    /**
     * Set the value of pessoaIdNome
     *
     * @return  self
     */ 
    public function setPessoaIdNome($pessoaIdNome)
    {
        $this->pessoaIdNome = $pessoaIdNome;

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

    private static function fromArray(array $data): PecaEletronica
    {
        return (new PecaEletronica())
            ->setId($data['id'])
            ->setPessoaId($data['pessoa_id'])
            ->setPessoaIdNome(
                isset($data['pessoa_id_nome']) 
                    ? $data['pessoa_id_nome'] 
                    : null
            )
            ->setNome($data['nome'])
            ->setTipo($data['tipo'])
            ->setModelo($data['modelo'])
            ->setSobre($data['sobre'])
            ->setImagem(Imagem::createByName($data['imagem']))
            ->setEstoque($data['estoque']);
    }

    private function storageImage()
    {
        $directory = __DIR__ . "/../../storage/parts/";

        if (!move_uploaded_file($this->imagem->tmpNamePath, $directory.$this->imagem->nameFormatted)) {
            throw new \Exception("Failed to upload image");
        }
    }

    public function inserir()
    {
        $this->imagem->setNameFormatted();
        $this->storageImage();

        $connection = PecaEletronica::getConnection();
        $query = "
            INSERT INTO peca_eletronica 
                (pessoa_id, nome, tipo, modelo, sobre, imagem, estoque) 
            VALUES (
                {$this->pessoaId}, 
                '{$this->nome}', 
                '{$this->tipo}', 
                '{$this->modelo}', 
                '{$this->sobre}', 
                '{$this->imagem->nameFormatted}',
                {$this->estoque}
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

    public static function getAll()
    {
        $conn = PecaEletronica::getConnection();
        
        $query = "
            SELECT 
                peca_eletronica.id, 
                peca_eletronica.pessoa_id, 
                peca_eletronica.nome, 
                peca_eletronica.tipo, 
                peca_eletronica.modelo, 
                peca_eletronica.sobre, 
                peca_eletronica.imagem, 
                peca_eletronica.estoque,
                pessoa.nome AS pessoa_id_nome
            FROM peca_eletronica
            INNER JOIN pessoa
                ON peca_eletronica.pessoa_id = pessoa.id
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $pecasEletronicas = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                $pecasEletronicas[] = PecaEletronica::fromArray($data);
        }

        $conn->close();
        return $pecasEletronicas;
    }

    public static function getAllByName(string $name)
    {
        $conn = PecaEletronica::getConnection();
        
        $query = "
            SELECT 
                peca_eletronica.id, 
                peca_eletronica.pessoa_id, 
                peca_eletronica.nome, 
                peca_eletronica.tipo, 
                peca_eletronica.modelo, 
                peca_eletronica.sobre, 
                peca_eletronica.imagem, 
                peca_eletronica.estoque,
                pessoa.nome AS pessoa_id_nome
            FROM peca_eletronica
            INNER JOIN pessoa
                ON peca_eletronica.pessoa_id = pessoa.id
            WHERE peca_eletronica.nome LIKE '%{$name}%'
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $pecasEletronicas = [];
        while ($obj = $result->fetch_assoc()) {
            if ($obj !== null)
                $pecasEletronicas[] = PecaEletronica::fromArray($obj);
        }

        $conn->close();
        return $pecasEletronicas;
    }

    public static function getAllByUserId(int $userId): array
    {
        $connection = PecaEletronica::getConnection();
        $query = "SELECT * FROM peca_eletronica WHERE pessoa_id = {$userId}";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $pecasEletronicas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row !== null)
                \array_push($pecasEletronicas, PecaEletronica::fromArray($row));
        }

        return $pecasEletronicas;
    }

    public static function getAllByIds(array $ids): array
    {
        $connection = PecaEletronica::getConnection();
        $query = "
            SELECT * 
            FROM peca_eletronica 
            WHERE id IN (" . implode(',', $ids) . ")
        ";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $pecasEletronicas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row !== null)
                \array_push($pecasEletronicas, PecaEletronica::fromArray($row));
        }

        return $pecasEletronicas;
    }

    public function editarPeca()
    {
        $connection = PecaEletronica::getConnection();

        if ($this->getImagem() != null) {
            $this->imagem->setNameFormatted();
            $this->storageImage();

            $query = "
                UPDATE peca_eletronica 
                SET 
                    nome = '{$this->getNome()}', 
                    tipo = '{$this->getTipo()}', 
                    modelo = '{$this->getModelo()}', 
                    sobre = '{$this->getSobre()}', 
                    imagem = '{$this->getImagem()->nameFormatted}', 
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

    public static function delete($partId)
    {
        $connection = PecaEletronica::getConnection();

        $query = "
            DELETE FROM peca_eletronica
            WHERE id = {$partId}
        ";

        $connection->query($query) or
            trigger_error("
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $connection->close();
        return true;
    }
}
