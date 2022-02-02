<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Interested;

class InterestedController 
{
    public static function isEletronicPartFavorited($eletronicPartId, $userId) {
        return Interested::isEletronicPartFavorited($eletronicPartId, $userId);
    }

    public static function favoriteEletronicPart($eletronicPartId, $userId) 
    {
        return Interested::favoriteEletronicPart($eletronicPartId, $userId);
    }

    public static function unfavoriteEletronicPart($eletronicPartId, $userId) 
    {
        return Interested::unfavoriteEletronicPart($eletronicPartId, $userId);
    }

    public static function getAllByUserId($userId): array 
    {
        return Interested::getAllByUserId($userId);
    }
}