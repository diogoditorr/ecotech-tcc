<?php

namespace Models;

class Pedido
{
    private string $id;
    private PecaEletronica|null $pecaEletronica;
    private Pessoa|null $doador;
    private Pessoa|null $cliente;
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
     * Get the value of doador
     */
    public function getDoador()
    {
        return $this->doador;
    }

    /**
     * Set the value of doador
     *
     * @return  self
     */
    public function setDoador($doador)
    {
        $this->doador = $doador;

        return $this;
    }

    /**
     * Get the value of cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @return  self
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

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

    private static function fromArray(
        array $data,
        bool $setPart = false,
        bool $setDonor = false
    ): Pedido {
        $pecaEletronica = (new PecaEletronica())->setId($data['peca_eletronica_id']);
        $doador = (new Pessoa())->setId($data['doador_id']);
        $cliente = (new Pessoa())->setId($data['cliente_id']);
            
        if ($setPart) {
            $pecaEletronica
                ->setPessoaId($doador->getId())
                ->setNome($data['peca_eletronica_nome'])
                ->setTipo($data['peca_eletronica_tipo'])
                ->setModelo($data['peca_eletronica_modelo'])
                ->setSobre($data['peca_eletronica_sobre'])
                ->setImagem(Imagem::createByName($data['peca_eletronica_imagem']))
                ->setEstoque($data['peca_eletronica_estoque']);
        }

        if ($setDonor) {
            $doador
                ->setCpf($data['doador_cpf'])
                ->setEmail($data['doador_email'])
                ->setNome($data['doador_nome'])
                ->setEscola($data['doador_escola'])
                ->setNumTelefone1($data['doador_num_telefone_1'])
                ->setNumTelefone2($data['doador_num_telefone_2'])
                ->setEndereco(
                    (new Endereco())
                        ->setEstado($data['doador_estado'])
                        ->setCidade($data['doador_cidade'])
                        ->setBairro($data['doador_bairro'])
                        ->setCep($data['doador_cep'])
                );
        }

        return (new Pedido())
            ->setId($data['id'])
            ->setPecaEletronica($pecaEletronica)
            ->setDoador($doador)
            ->setCliente($cliente)
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
                {$this->doador->getId()}, 
                {$this->cliente->getId()}
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
                peca_eletronica.nome as peca_eletronica_nome,
                peca_eletronica.tipo as peca_eletronica_tipo,
                peca_eletronica.modelo as peca_eletronica_modelo,
                peca_eletronica.sobre as peca_eletronica_sobre,
                peca_eletronica.imagem as peca_eletronica_imagem,
                peca_eletronica.estoque as peca_eletronica_estoque
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
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($pedidos, Pedido::fromArray($data, setPart: true));
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
                peca_eletronica.nome as peca_eletronica_nome,
                peca_eletronica.tipo as peca_eletronica_tipo,
                peca_eletronica.modelo as peca_eletronica_modelo,
                peca_eletronica.sobre as peca_eletronica_sobre,
                peca_eletronica.imagem as peca_eletronica_imagem,
                peca_eletronica.estoque as peca_eletronica_estoque
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
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($pedidos, Pedido::fromArray($data, setPart: true));
        }

        return $pedidos;
    }

    public static function getDetailsById($id)
    {
        $conn = Pedido::getConnection();
        /*
            Query that joins three tables: pedidos, peca_eletronica and pessoa
        */
        $query = "
            SELECT 
                pedidos.id,
                pedidos.peca_eletronica_id,
                pedidos.doador_id,
                pedidos.cliente_id,
                pedidos.status,
                pedidos.created_at,
                peca_eletronica.nome as peca_eletronica_nome,
                peca_eletronica.tipo as peca_eletronica_tipo,
                peca_eletronica.modelo as peca_eletronica_modelo,
                peca_eletronica.sobre as peca_eletronica_sobre,
                peca_eletronica.imagem as peca_eletronica_imagem,
                peca_eletronica.estoque as peca_eletronica_estoque,
                pessoa.cpf AS doador_cpf,
                pessoa.email AS doador_email,
                pessoa.nome AS doador_nome,
                pessoa.escola as doador_escola,
                pessoa.num_telefone_1 AS doador_num_telefone_1,
                pessoa.num_telefone_2 AS doador_num_telefone_2,
                endereco.estado AS doador_estado,
                endereco.cidade AS doador_cidade,
                endereco.bairro AS doador_bairro,
                endereco.cep AS doador_cep
            FROM pedidos
            INNER JOIN peca_eletronica 
                ON pedidos.peca_eletronica_id = peca_eletronica.id
            INNER JOIN pessoa 
                ON pedidos.doador_id = pessoa.id
            INNER JOIN endereco
                ON pedidos.doador_id = endereco.pessoa_id
            WHERE pedidos.id = '{$id}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            $conn->close();
            return null;
        }

        $pedido = Pedido::fromArray($data, setPart: true, setDonor: true);

        $conn->close();
        return $pedido;
    }
}
