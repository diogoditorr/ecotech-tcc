<?php declare(strict_types=1);

namespace App\Php;

use App\Controllers\InterestedController;
use App\Models\Interested;

class Util
{
    public static function getFavoritedEletronicPartsId(int $userId)
    {
        return array_map(function (Interested $interested) {
            return (int) $interested->getEletronicPartId();
        }, InterestedController::getAllByUserId($userId));
    }

    public static function parseStatus($status)
    {
        return match ($status) {
            'pendente' => 'pending',
            'entregue' => 'delivered',
            'cancelado' => 'cancelled',
            default => 'pending'
        };
    }

    public static function getRequiredVariablesEnvironment()
    {
        return ['DB_ADAPTER', 'DB_NAME', 'DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_PORT'];
    }
};
