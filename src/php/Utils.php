<?php

namespace Php;

use Controllers\InteressadosController;
use Models\Interessado;

class Utils {
    public static function getFavoritedPartsId(string $userId)
    {
        return array_map(function (Interessado $interested) {
            return (int) $interested->getPecaEletronicaId();
        }, InteressadosController::getAllByUserId($userId));
    }

    public static function parseStatus($status) {
        return match ($status) {
            'pendente' => 'pending',
            'entregue' => 'delivered',
            'cancelado' => 'cancelled',
            default => 'pending'
        };
    }
};