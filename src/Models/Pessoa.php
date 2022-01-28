<?php

namespace Models;

use ConexaoDB;
use Models\BaseModel;

class Pessoa extends BaseModel
{
    protected int $id;
    protected string $cpf;
    protected string $email;
    protected string $nome;
    protected string $escola;
    protected string $numTelefone1;
    protected string $numTelefone2;
    protected Endereco $endereco;

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
    public function setCpf($cpf)
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
    public function setEmail($email)
    {
        $this->email = $email;

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
     * Get the value of escola
     */ 
    public function getEscola()
    {
        return $this->escola;
    }

    /**
     * Set the value of escola
     *
     * @return  self
     */ 
    public function setEscola($escola)
    {
        $this->escola = $escola;

        return $this;
    }

    /**
     * Get the value of numTelefone1
     */ 
    public function getNumTelefone1()
    {
        return $this->numTelefone1;
    }

    /**
     * Set the value of numTelefone1
     *
     * @return  self
     */ 
    public function setNumTelefone1($numTelefone1)
    {
        $this->numTelefone1 = $numTelefone1;

        return $this;
    }

    /**
     * Get the value of numTelefone2
     */ 
    public function getNumTelefone2()
    {
        return $this->numTelefone2;
    }

    /**
     * Set the value of numTelefone2
     *
     * @return  self
     */ 
    public function setNumTelefone2($numTelefone2)
    {
        $this->numTelefone2 = $numTelefone2;

        return $this;
    }

    /**
     * Get the value of endereco
     */ 
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @return  self
     */ 
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";

        return ConexaoDB::conectar();
    }

    private static function fromArray(array $data): Pessoa
    {
        $endereco = (new Endereco())
                        ->setPessoaId($data["id"])
                        ->setEstado($data["estado"])
                        ->setCidade($data["cidade"])
                        ->setBairro($data["bairro"])
                        ->setCep($data["cep"]);

        return (new Pessoa())
                    ->setId($data['id'])
                    ->setCpf($data['cpf'])
                    ->setEmail($data['email'])
                    ->setNome($data['nome'])
                    ->setNumTelefone1($data['num_telefone_1'])
                    ->setNumTelefone2($data['num_telefone_2'])
                    ->setEndereco($endereco);
    }
                
    private static function get($column, $data)
    {
        $conn = Pessoa::getConnection();

        $query = "
            SELECT 
                pessoa.id,
                pessoa.cpf,
                pessoa.email,
                pessoa.nome,
                pessoa.num_telefone_1,
                pessoa.num_telefone_2,
                endereco.estado,
                endereco.cidade,
                endereco.bairro,
                endereco.cep
            FROM pessoa
            INNER JOIN endereco 
                ON pessoa.id = endereco.pessoa_id
            WHERE pessoa.{$column} = '{$data}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $arrayObject = $result->fetch_assoc();

        if ($arrayObject === null) {
            $conn->close();
            return null;
        }

        $person = Pessoa::fromArray($arrayObject);

        $conn->close();
        return $person;
    }

    public static function getById($pessoaId)
    {
        return Pessoa::get("id", $pessoaId);
    }
    
    public static function getByEmail($email)
    {
        return Pessoa::get("email", $email);
    }
    
    public static function getByCpf($cpf)
    {
        return Pessoa::get("cpf", $cpf);
    }

    public static function getIdByCpf(string $cpf)
    {
        $conn = Pessoa::getConnection();

        $query = "
            SELECT id
            FROM pessoa
            WHERE cpf = '{$cpf}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $arrayObject = $result->fetch_assoc();

        if ($arrayObject === null) {
            $conn->close();
            return null;
        }

        $conn->close();
        return $arrayObject['id'];
    }

    public function inserir(): bool
    {
        $conn = Pessoa::getConnection();

        $query = "
            INSERT INTO pessoa
                (cpf, email, nome, escola, num_telefone_1, num_telefone_2)
            VALUES (
                '{$this->getCpf()}',
                '{$this->getEmail()}',
                '{$this->getNome()}',
                '{$this->getEscola()}',
                '{$this->getNumTelefone1()}',
                '{$this->getNumTelefone2()}'
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
