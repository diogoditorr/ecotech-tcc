<?php

namespace Controllers;

use Models\Pedido;
use Models\PecaEletronica;

class PedidosController 
{
    public static function fazerPedido(array $data)
    {
        date_default_timezone_set('America/Sao_Paulo');

        // Create random id with characters and numbers (8 characters) without 
        // spaces and special characters
        $id = substr(md5(uniqid(rand(), true)), 0, 8);

        $result = (new Pedido())
            ->setId($id)
            ->setPecaEletronica(
                (new PecaEletronica())->setId($data['partId'])
            )
            ->setDoadorId($data['doadorId'])
            ->setClienteId($_SESSION['user_id'])
            ->setCreated_at(date('d-m-Y H:i:s'))
            ->inserir();

        if (!$result) {
            return [
                'success' => false,
                'error' => 'Não foi possível fazer o pedido'
            ];
        }
        
        return [
            'success' => true,
            'error' => null
        ];
    }

    public static function getAllByClientId($clientId)
    {
        return Pedido::getAllByClientId($clientId);
    }

    public static function getAllByDonorId($donorId)
    {
        return Pedido::getAllByDonorId($donorId);
    }
}