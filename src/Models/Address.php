<?php declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\BaseModel;

class Address extends BaseModel
{
    protected int $id;
    protected int $personId;
    protected string $address;
    protected string $city;
    protected string $state;
    protected string $district;
    protected string $zipCode;

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
    public function setPersonId(int $personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of district
     */ 
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of district
     *
     * @return  self
     */ 
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get the value of zipCode
     */ 
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set the value of zipCode
     *
     * @return  self
     */ 
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::connect();
    }

    private static function fromArray(array $data)
    {
        return (new Address())
                    ->setPersonId($data["person_id"])
                    ->setAddress($data["address"])
                    ->setState($data["state"])
                    ->setCity($data["city"])
                    ->setDistrict($data["district"])
                    ->setZipCode($data["zip_code"]);
    }

    public function insert(): bool
    {
        $conn = Address::getConnection();

        $query = "
            INSERT INTO address 
                (person_id, address, city, state, district, zip_code)
            VALUES (
                {$this->personId},
                '{$this->address}',
                '{$this->city}',
                '{$this->state}',
                '{$this->district}',
                '{$this->zipCode}'
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