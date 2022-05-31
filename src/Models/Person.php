<?php declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\BaseModel;

class Person extends BaseModel
{
    protected int $id;
    protected string $cpf;
    protected string $email;
    protected string $name;
    protected string $school;
    protected string $phoneNumber1;
    protected string $phoneNumber2;
    protected Address $address;

    protected array $hidden = [
        'cpf'
    ];

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
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

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
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of school
     */ 
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set the value of school
     *
     * @return  self
     */ 
    public function setSchool(string $school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get the value of phoneNumber1
     */ 
    public function getPhoneNumber1()
    {
        return $this->phoneNumber1;
    }

    /**
     * Set the value of phoneNumber1
     *
     * @return  self
     */ 
    public function setPhoneNumber1(string $phoneNumber1)
    {
        $this->phoneNumber1 = $phoneNumber1;

        return $this;
    }

    /**
     * Get the value of phoneNumber2
     */ 
    public function getPhoneNumber2()
    {
        return $this->phoneNumber2;
    }

    /**
     * Set the value of phoneNumber2
     *
     * @return  self
     */ 
    public function setPhoneNumber2(string $phoneNumber2)
    {
        $this->phoneNumber2 = $phoneNumber2;

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
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::getInstance();
    }

    private static function fromArray(array $data): Person
    {
        $address = (new Address())
                        ->setPersonId((int) $data["id"])
                        ->setAddress($data["address"])
                        ->setCity($data["city"])
                        ->setState($data["state"])
                        ->setDistrict($data["district"])
                        ->setZipCode($data["zip_code"]);

        return (new Person())
                    ->setId((int) $data['id'])
                    ->setCpf($data['cpf'])
                    ->setEmail($data['email'])
                    ->setName($data['name'])
                    ->setSchool($data['school'])
                    ->setPhoneNumber1($data['phone_number_1'])
                    ->setPhoneNumber2($data['phone_number_2'])
                    ->setAddress($address);
    }
                
    private static function get($column, $data)
    {
        $conn = Person::getConnection();

        $query = "
            SELECT 
                person.id,
                person.cpf,
                person.email,
                person.name,
                person.school,
                person.phone_number_1,
                person.phone_number_2,
                address.address,
                address.city,
                address.state,
                address.district,
                address.zip_code
            FROM person
            INNER JOIN address 
                ON person.id = address.person_id
            WHERE person.{$column} = '{$data}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            return null;
        }

        $person = Person::fromArray($data);

        return $person;
    }

    public static function getById($personId)
    {
        return Person::get("id", $personId);
    }
    
    public static function getByEmail($email)
    {
        return Person::get("email", $email);
    }
    
    public static function getByCpf($cpf)
    {
        return Person::get("cpf", $cpf);
    }

    public static function getIdByCpf(string $cpf): string
    {
        $conn = Person::getConnection();

        $query = "
            SELECT id
            FROM person
            WHERE cpf = '{$cpf}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            return null;
        }

        return $data['id'];
    }

    public function insert(): bool
    {
        $conn = Person::getConnection();

        $query = "
            INSERT INTO person
                (cpf, email, name, school, phone_number_1, phone_number_2)
            VALUES (
                '{$this->cpf}',
                '{$this->email}',
                '{$this->name}',
                '{$this->school}',
                '{$this->phoneNumber1}',
                '{$this->phoneNumber2}'
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
