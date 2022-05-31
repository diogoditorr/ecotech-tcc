<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Image;
use App\Models\EletronicPart;

class EletronicPartsController
{
    public static function formatImage(array $image): Image
    {
        $imageObject = new Image($image);
        $imageObject->setNameFormatted();

        return $imageObject;
    }

    public static function storeImage(Image $image): bool
    {
        $newEletronicPart = (new EletronicPart())
            ->setImage($image);

        return $newEletronicPart->storeImage();
    }

    public static function register(array $data)
    {
        if (!($data['image'] instanceof Image))
            return ['success' => false, 'error' => 'Image instance is required'];    

        if (!self::validateImageExtension($data['image']))
            return [
                'success' => false,
                'error' => 'Invalid image extension'
            ];

        try {
            $newEletronicPart = (new EletronicPart())
                ->setPersonId($data['userId'])
                ->setName($data['name'])
                ->setType($data['type'])
                ->setModel($data['model'])
                ->setDescription($data['description'])
                ->setStock((int) $data['stock'])
                ->setImage($data['image']);

            $newEletronicPart->insert();
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

    public static function getById(int $eletronicPartId)
    {
        return EletronicPart::getById($eletronicPartId);
    }

    public static function edit(array $data)
    {
        if ($data['image'] !== null && !($data['image'] instanceof Image))
            return ['success' => false, 'error' => 'Image instance is required'];    
            
        if (!self::validateImageExtension($data['image']))
            return [
                'success' => false,
                'error' => 'Invalid image extension'
            ];

        try {
            (new EletronicPart)
                ->setId((int) $data['id'])
                ->setPersonId($data['userId'])
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

    public static function updateStock(int $eletronicPartId, int $quantity)
    {
        return EletronicPart::updateStock($eletronicPartId, $quantity);
    }

    public static function delete(int $eletronicPartId)
    {
        return EletronicPart::delete($eletronicPartId);
    }

    private static function validateImageExtension(Image $image)
    {
        $extensions = ['png', 'jpeg', 'jpg'];
        if (!in_array($image->extension, $extensions)) {
            throw new \Exception(
                "Invalid extension file. It must be " . \implode(' - ', $extensions) .
                    "; \"$image->extension\" given."
            );
        }

        return true;
    }
}
