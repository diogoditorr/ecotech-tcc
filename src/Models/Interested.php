<?php declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\BaseModel;

class Interested extends BaseModel
{
    protected int $id;
    protected int $personId;
    protected int $eletronicPartId;

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
     * Get the value of personId
     */ 
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set the value of personId
     *
     * @return  self
     */ 
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get the value of eletronicPartId
     */ 
    public function getEletronicPartId()
    {
        return $this->eletronicPartId;
    }

    /**
     * Set the value of eletronicPartId
     *
     * @return  self
     */ 
    public function setEletronicPartId($eletronicPartId)
    {
        $this->eletronicPartId = $eletronicPartId;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::getInstance();
    }

    private static function fromArray(array $data): Interested
    {
        $interested = (new Interested())
                            ->setId((int) $data["id"])
                            ->setPersonId((int) $data["person_id"])
                            ->setEletronicPartId((int) $data["eletronic_part_id"]);

        return $interested;
    }

    public static function isEletronicPartFavorited($eletronicPartId, $userId): bool
    {
        $connection = self::getConnection();

        $query = "
            SELECT * 
            FROM interested
            WHERE 
                person_id = {$userId} AND 
                eletronic_part_id = {$eletronicPartId}
        ";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            return true;
        }

        return false;
    }

    public static function favoriteEletronicPart($eletronicPartId, $userId)
    {
        $connection = self::getConnection();

        $query = "
            INSERT INTO interested (person_id, eletronic_part_id)
            VALUES ({$userId}, {$eletronicPartId})
        ";

        $result = $connection->query($query);

        if ($result === false) {
            return false;
        }
        
        return true;
    }

    public static function unfavoriteEletronicPart($eletronicPartId, $userId)
    {
        $connection = self::getConnection();

        $query = "
            DELETE FROM interested 
            WHERE 
                person_id = {$userId} AND 
                eletronic_part_id = {$eletronicPartId}
        ";

        $result = $connection->query($query);

        

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
            FROM interested
            WHERE person_id = {$userId}
        ";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $interested = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                $interested[] = Interested::fromArray($data);
        }

        
        return $interested;
    }
}