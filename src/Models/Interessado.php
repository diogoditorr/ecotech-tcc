<?php

namespace Models;

use Models\BaseModel;
class Interessado extends BaseModel
{
    protected int $id;
    protected int $pessoaId;
    protected int $pecaEletronicaId;

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
        
        return \ConexaoDB::conectar();
    }

    private static function fromArray(array $data): Interessado
    {
        $interessado = (new Interessado())
                            ->setId($data["id"])
                            ->setPessoaId($data["pessoa_id"])
                            ->setPecaEletronicaId($data["peca_eletronica_id"]);

        return $interessado;
    }

    public static function isPartFavorited($partId, $userId): bool
    {
        $connection = self::getConnection();

        $query = "
            SELECT * 
            FROM interessados
            WHERE 
                pessoa_id = {$userId} AND 
                peca_eletronica_id = {$partId}
        ";

        $result = $connection->query($query);

        $connection->close();

        if ($result->num_rows > 0) {
            return true;
        }

        return false;
    }

    public static function favoritePart($partId, $userId)
    {
        $connection = self::getConnection();

        $query = "
            INSERT INTO interessados (pessoa_id, peca_eletronica_id)
            VALUES ({$userId}, {$partId})
        ";

        $result = $connection->query($query);

        $connection->close();

        if ($result === false) {
            return false;
        }
        
        return true;
    }

    public static function unfavoritePart($partId, $userId)
    {
        $connection = self::getConnection();

        $query = "
            DELETE FROM interessados 
            WHERE 
                pessoa_id = {$userId} AND 
                peca_eletronica_id = {$partId}
        ";

        $result = $connection->query($query);

        $connection->close();

        if ($result === false) {
            return false;
        }
        
        return true;
    }

    public static function getAllByUserId(int $userId): array
    {
        $connection = self::getConnection();

        $query = "
            SELECT * 
            FROM interessados
            WHERE pessoa_id = {$userId}
        ";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $interessados = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                $interessados[] = Interessado::fromArray($data);
        }

        $connection->close();
        return $interessados;
    }
}