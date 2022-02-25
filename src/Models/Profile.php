<?php declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\BaseModel;

class Profile extends BaseModel
{
    protected int $id;
    protected int $personId;
    protected string $cpf;
    protected string $email;
    protected string $userName;
    protected string $password;

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
     * Get the value of userName
     */ 
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName(string $userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::getInstance();
    }

    private static function fromArray(array $data): Profile
    {
        return (new Profile())
                    ->setId((int) $data['id'])
                    ->setPersonId((int) $data['person_id'])
                    ->setEmail($data['email'])
                    ->setCpf($data['cpf'])
                    ->setUserName($data['user_name'])
                    ->setPassword($data['password']);
    }
    
    private static function get($column, $data)
    {
        $conn = Profile::getConnection();
        $query = "SELECT * FROM profile WHERE {$column} = '{$data}'";

        $result = $conn->query($query);

        if (!$result) {
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            $conn -> close();
            return null;
        }

        $profile = Profile::fromArray($data);

        return $profile;
    }

    public static function getByPersonId($personId)
    {
        return Profile::get("person_id", $personId);
    }
    
    public static function getByCpf($cpf)
    {
        return Profile::get("cpf", $cpf);
    }
    
    public static function getByEmail($email)
    {
        return Profile::get("email", $email);
    }

    public function insert(): bool
    {
        $conn = Profile::getConnection();

        $query = "
            INSERT INTO profile 
                (person_id, cpf, email, user_name, password)
            VALUES (
                '{$this->personId}',
                '{$this->cpf}',
                '{$this->email}',
                '{$this->userName}',
                '{$this->password}'
            )
        ";

        $conn->query($query) or
            trigger_error("
                Query Failed! SQL: $query - Error: ". mysqli_error($conn), 
                E_USER_ERROR
            );

        return true;
    }
    
    public static function verifyUserCredentials($cpf, $email, $password)
    {
        $conn = Profile::getConnection();

        $result = $conn->query("
            SELECT * FROM profile 
            WHERE 
                (cpf = '{$cpf}' OR email = '{$email}') AND 
                password = '{$password}'
        ");

        if (!$result) {
            return false;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            return false;
        }

        $profile = Profile::fromArray($data);

        return $profile;
    }


    public static function hasDataAlreadyRegistered(string $cpf, string $email, string $username)
    {
        $conn = Profile::getConnection();

        $result = $conn->query("
            SELECT * FROM profile
            WHERE 
                cpf = '{$cpf}' OR
                email = '{$email}' OR
                user_name = '{$username}' 
            ;
        ");

        if ($result->num_rows > 0) {
            return true;
        }
        
        return false;
    }
}
