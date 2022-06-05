<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Interested;

class InterestedController 
{
    public static function isEletronicPartFavorited(int $eletronicPartId, int $userId) {
        return Interested::isEletronicPartFavorited($eletronicPartId, $userId);
    }

    public static function favoriteEletronicPart(int $eletronicPartId, int $userId) 
    {
        return Interested::favoriteEletronicPart($eletronicPartId, $userId);
    }

    public static function unfavoriteEletronicPart(int $eletronicPartId, int $userId) 
    {
        return Interested::unfavoriteEletronicPart($eletronicPartId, $userId);
    }

    public static function getAllByUserId(int $userId): array 
    {
        return Interested::getAllByUserId($userId);
    }
}