<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\Image;
use App\Models\BaseModel;

class EletronicPart extends BaseModel
{
    protected int $id;
    protected int $personId;
    protected ?string $personIdName;
    protected ?string $name;
    protected ?string $type;
    protected ?string $model;
    protected ?string $description;
    protected ?Image $image;
    protected int $stock;

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
    public function setId(int $id)
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
    public function setPersonId(int $personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get the value of personIdName
     */
    public function getPersonIdName()
    {
        return $this->personIdName;
    }

    /**
     * Set the value of personIdName
     *
     * @return  self
     */
    public function setPersonIdName(?string $personIdName)
    {
        $this->personIdName = $personIdName;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */
    public function setModel(?string $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage(?Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::getInstance();
    }

    private static function fromArray(array $data): EletronicPart
    {
        return (new EletronicPart())
            ->setId((int) $data['id'])
            ->setPersonId((int) $data['person_id'])
            ->setPersonIdName(
                isset($data['person_id_name'])
                    ? $data['person_id_name']
                    : null
            )
            ->setName($data['name'])
            ->setType($data['type'])
            ->setModel($data['model'])
            ->setDescription($data['description'])
            ->setImage(Image::createByName($data['image_identifier']))
            ->setStock((int) $data['stock']);
    }

    public function storeImage()
    {
        $directory = __DIR__ . "/../../storage/parts/";

        if (!move_uploaded_file($this->image->tmpNamePath, $directory . $this->image->nameFormatted)) {
            throw new \Exception("Failed to upload image");
        }

        return true;
    }

    public function insert()
    {
        $connection = EletronicPart::getConnection();
        $query = "
            INSERT INTO eletronic_part 
                (person_id, name, type, model, description, image_identifier, stock)
            VALUES (
                {$this->personId},
                '{$this->name}', 
                '{$this->type}', 
                '{$this->model}', 
                '{$this->description}', 
                '{$this->image->nameFormatted}',
                {$this->stock}
            )
        ";

        $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        return true;
    }

    public static function getById(int $eletronicPartId)
    {
        $conn = EletronicPart::getConnection();
        $query = "SELECT * FROM eletronic_part WHERE id = {$eletronicPartId}";

        $result = $conn->query($query);

        if (!$result) {
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            return null;
        }

        $eletronicPart = EletronicPart::fromArray($data);

        return $eletronicPart;
    }

    public static function getAll()
    {
        $conn = EletronicPart::getConnection();

        $query = "
            SELECT 
                eletronic_part.id, 
                eletronic_part.person_id, 
                eletronic_part.name, 
                eletronic_part.type, 
                eletronic_part.model, 
                eletronic_part.description, 
                eletronic_part.image_identifier, 
                eletronic_part.stock,
                person.name AS person_id_name
            FROM eletronic_part
            INNER JOIN person
                ON eletronic_part.person_id = person.id
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $eletronicParts = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                $eletronicParts[] = EletronicPart::fromArray($data);
        }

        return $eletronicParts;
    }

    public static function getAllByName(string $name)
    {
        $conn = EletronicPart::getConnection();

        $query = "
            SELECT 
                eletronic_part.id, 
                eletronic_part.person_id, 
                eletronic_part.name, 
                eletronic_part.type, 
                eletronic_part.model, 
                eletronic_part.description, 
                eletronic_part.image_identifier, 
                eletronic_part.stock,
                person.name AS person_id_name
            FROM eletronic_part
            INNER JOIN person
                ON eletronic_part.person_id = person.id
            WHERE eletronic_part.name LIKE '%{$name}%'
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $eletronicParts = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                $eletronicParts[] = EletronicPart::fromArray($data);
        }

        return $eletronicParts;
    }

    public static function getAllByUserId(int $userId): array
    {
        $connection = EletronicPart::getConnection();
        $query = "SELECT * FROM eletronic_part WHERE person_id = {$userId}";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $eletronicParts = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($eletronicParts, EletronicPart::fromArray($data));
        }

        return $eletronicParts;
    }

    public static function getAllByIds(array $ids): array
    {
        $connection = EletronicPart::getConnection();
        $query = "
            SELECT * 
            FROM eletronic_part 
            WHERE id IN (" . implode(',', $ids) . ")
        ";

        $result = $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $eletronicParts = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($eletronicParts, EletronicPart::fromArray($data));
        }

        return $eletronicParts;
    }

    public function edit()
    {
        $connection = EletronicPart::getConnection();

        if ($this->image !== null) {
            $query = "
                UPDATE eletronic_part 
                SET
                    person_id = {$this->personId},
                    name = '{$this->name}',
                    type = '{$this->type}',
                    model = '{$this->model}',
                    description = '{$this->description}',
                    image_identifier = '{$this->image->nameFormatted}',
                    stock = {$this->stock}
                WHERE 
                    id = {$this->id}
            ";
        } else {
            $query = "
                UPDATE eletronic_part 
                SET
                    person_id = {$this->personId},
                    name = '{$this->name}',
                    type = '{$this->type}',
                    model = '{$this->model}',
                    description = '{$this->description}',
                    stock = {$this->stock}
                WHERE 
                    id = {$this->id}
            ";
        }

        $connection->query($query) or
            trigger_error(
                "
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        return true;
    }

    public static function updateStock(int $eletronicPartId, int $quantity)
    {
        $connection = EletronicPart::getConnection();
        $query = "
            UPDATE eletronic_part 
            SET 
                stock = {$quantity} 
            WHERE 
                id = {$eletronicPartId}
        ";

        $connection->query($query) or
            trigger_error(
                "
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        return true;
    }

    public static function delete($eletronicPartId)
    {
        $connection = EletronicPart::getConnection();

        $query = "
            DELETE FROM eletronic_part
            WHERE id = {$eletronicPartId}
        ";

        $connection->query($query) or
            trigger_error(
                "
                Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        return true;
    }
}
