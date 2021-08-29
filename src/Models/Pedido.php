<?php

namespace Models;

class Pedido
{
    private string $id;
    private PecaEletronica $pecaEletronica;
    private string $doadorId;
    private string $clienteId;
    private string $status;
    private string $created_at;

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
     * Get the value of pecaEletronica
     */ 
    public function getPecaEletronica()
    {
        return $this->pecaEletronica;
    }

    /**
     * Set the value of pecaEletronica
     *
     * @return  self
     */ 
    public function setPecaEletronica($pecaEletronica)
    {
        $this->pecaEletronica = $pecaEletronica;

        return $this;
    }

    /**
     * Get the value of doadorId
     */ 
    public function getDoadorId()
    {
        return $this->doadorId;
    }

    /**
     * Set the value of doadorId
     *
     * @return  self
     */ 
    public function setDoadorId($doadorId)
    {
        $this->doadorId = $doadorId;

        return $this;
    }

    /**
     * Get the value of clienteId
     */ 
    public function getClienteId()
    {
        return $this->clienteId;
    }

    /**
     * Set the value of clienteId
     *
     * @return  self
     */ 
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        require_once "../../database/ConexaoDB.php";
        
        return \ConexaoDB::conectar();
    }

    private static function fromArray(array $data)
    {
        $pecaEletronica = (new PecaEletronica())
                        ->setId($data['peca_eletronica_id'])
                        ->setNome($data['nome'])
                        ->setImagem(Imagem::createByName($data['imagem']));

        return (new Pedido())
                    ->setId($data['id'])
                    ->setPecaEletronica($pecaEletronica)
                    ->setDoadorId($data['doador_id'])
                    ->setClienteId($data['cliente_id'])
                    ->setStatus($data['status'])
                    ->setCreated_at($data['created_at']);
    }

    public function inserir()
    {
        $connection = Pedido::getConnection();
        $query = "
            INSERT INTO pedidos 
                (id, peca_eletronica_id, doador_id, cliente_id)
            VALUES (
                '{$this->id}',
                {$this->pecaEletronica->getId()}, 
                {$this->doadorId}, 
                {$this->clienteId}
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

    public static function getAllByClientId($clientId)
    {
        $conn = Pedido::getConnection();

        $query = "
            SELECT 
                pedidos.id,
                pedidos.peca_eletronica_id,
                pedidos.doador_id,
                pedidos.cliente_id,
                pedidos.status,
                pedidos.created_at,
                peca_eletronica.nome,
                peca_eletronica.imagem
            FROM pedidos
            INNER JOIN peca_eletronica 
                ON pedidos.peca_eletronica_id = peca_eletronica.id
            WHERE pedidos.cliente_id = '{$clientId}'
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            if ($row !== null)
                \array_push($pedidos, Pedido::fromArray($row));
        }

        return $pedidos;
    }

    public static function getAllByDonorId($donorId)
    {
        $conn = Pedido::getConnection();

        $query = "
            SELECT 
                pedidos.id,
                pedidos.peca_eletronica_id,
                pedidos.doador_id,
                pedidos.cliente_id,
                pedidos.status,
                pedidos.created_at,
                peca_eletronica.nome,
                peca_eletronica.imagem
            FROM pedidos
            INNER JOIN peca_eletronica 
                ON pedidos.peca_eletronica_id = peca_eletronica.id
            WHERE pedidos.doador_id = '{$donorId}'
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            if ($row !== null)
                \array_push($pedidos, Pedido::fromArray($row));
        }

        return $pedidos;
    }
}