<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\EletronicPart;
use App\Models\Person;
use App\Models\Order;

class OrdersController
{
    public static function requestOrder(array $data)
    {
        date_default_timezone_set('America/Sao_Paulo');

        // Create random id with characters and numbers (8 characters) without 
        // spaces and special characters
        $id = substr(md5(uniqid((string) rand(), true)), 0, 8);
        $data['eletronicPartId'] = (int) $data['eletronicPartId'];
        $data['donorId'] = (int) $data['donorId'];

        $eletronicPart = EletronicPartsController::getById($data['eletronicPartId']);

        if ($eletronicPart->getStock() <= 0)
            return [
                'success' => false,
                'error' => 'Não há estoque disponível para essa peça'
            ];

        $result = (new Order())
            ->setId($id)
            ->setEletronicPart(
                (new EletronicPart())->setId($data['eletronicPartId'])
            )
            ->setDonor(
                (new Person())->setId($data['donorId'])
            )
            ->setReceiver(
                (new Person())->setId($_SESSION['user_id'])
            )
            ->insert();

        if (!$result) {
            return [
                'success' => false,
                'error' => 'Não foi possível fazer o pedido'
            ];
        }

        EletronicPartsController::updateStock(
            $eletronicPart->getId(),
            $eletronicPart->getStock() - 1
        );

        return [
            'success' => true,
            'error' => null
        ];
    }

    public static function getAllByReceiverId($receiverId)
    {
        return Order::getAllByReceiverId($receiverId);
    }

    public static function getAllByDonorId($donorId)
    {
        return Order::getAllByDonorId($donorId);
    }

    public static function getDetailsById($id)
    {
        return Order::getDetailsById($id);
    }

    public static function changeStatus($id, $status)
    {
        return Order::changeStatus($id, $status);
    }

    public static function delete($id)
    {
        return Order::delete($id);
    }
}
