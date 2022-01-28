<?php

namespace Controllers;

use Models\Interessado;

class InteressadosController 
{
    public static function isPartFavorited($partId, $userId) {
        return Interessado::isPartFavorited($partId, $userId);
    }

    public static function favoritePart($partId, $userId) 
    {
        return Interessado::favoritePart($partId, $userId);
    }

    public static function unfavoritePart($partId, $userId) 
    {
        return Interessado::unfavoritePart($partId, $userId);
    }

    public static function getAllByUserId($userId): array 
    {
        return Interessado::getAllByUserId($userId);
    }
}