<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Image;
use App\Models\EletronicPart;

class EletronicPartsController 
{
    public static function register(array $data)
    {
        // Validate specific data
        $data['image'] = new Image($data['image']);
        EletronicPartsController::validateImageExtension($data['image']);

        try {
            (new EletronicPart())
                ->setPersonId($data['userId'])
                ->setName($data['name'])
                ->setType($data['type'])
                ->setModel($data['model'])
                ->setDescription($data['description'])
                ->setStock((int) $data['stock'])
                ->setImage($data['image'])
                ->insert();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'error' => null
        ];
    }

    public static function getAll()
    {
        return EletronicPart::getAll();
    }

    public static function getAllByName(string $name)
    {
        return EletronicPart::getAllByName($name);
    }

    public static function getAllByUserId(int $userId)
    {
        return EletronicPart::getAllByUserId($userId);
    }

    public static function getAllByIds(array $ids)
    {
        return EletronicPart::getAllByIds($ids);
    }

    public static function getById($eletronicPartId)
    {
        return EletronicPart::getById($eletronicPartId);
    }

    public static function edit(array $data)
    {
        if ($data['image'] !== null)
            $data['image'] = new Image($data['image']);
        
        try {
            (new EletronicPart)
                ->setId((int) $data['id'])
                ->setPersonId($_SESSION['user_id'])
                ->setName($data['name'])
                ->setType($data['type'])
                ->setModel($data['model'])
                ->setDescription($data['description'])
                ->setStock((int) $data['stock'])
                ->setImage($data['image'])
                ->edit();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'error' => null
        ];
    }

    public static function updateStock($eletronicPartId,int $quantity) {
        return EletronicPart::updateStock($eletronicPartId, $quantity);
    }

    public static function delete(int $eletronicPartId)
    {
        return EletronicPart::delete($eletronicPartId);
    }

    private static function validateImageExtension(Image $image) {
        $extensions = ['png', 'jpeg', 'jpg'];
        if (!in_array($image->extension, $extensions)) {
            throw new \Exception(
                "Invalid extension file. It must be ".\implode(' - ', $extensions).
                "; \"$image->extension\" given."
            );
        }
    }
}