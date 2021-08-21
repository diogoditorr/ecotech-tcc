<?php

namespace Controllers;

use Models\Imagem;
use Models\PecaEletronica;

class PecasEletronicasController 
{
    public static function registrarPeca(array $data)
    {
        // Validate specific data
        $data['image'] = new Imagem($data['image']);
        PecasEletronicasController::validateImageExtension($data['image']);

        try {
            (new PecaEletronica())
                ->setPessoaId($_SESSION['user_id'])
                ->setNome($data['name'])
                ->setTipo($data['type'])
                ->setModelo($data['model'])
                ->setSobre($data['about'])
                ->setEstoque($data['stock'])
                ->setImagem($data['image'])
                ->inserir();
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
        return PecaEletronica::getAll();
    }

    public static function getAllByName(string $name)
    {
        return PecaEletronica::getAllByName($name);
    }

    public static function getAllByUserId(int $userId)
    {
        return PecaEletronica::getAllByUserId($userId);
    }

    public static function getById($pecaId)
    {
        return PecaEletronica::getById($pecaId);
    }

    public static function editarPeca(array $data)
    {
        if ($data['image'] !== null)
            $data['image'] = new Imagem($data['image']);
        
        try {
            (new PecaEletronica)
                ->setId($data['id'])
                ->setNome($data['name'])
                ->setTipo($data['type'])
                ->setModelo($data['model'])
                ->setSobre($data['about'])
                ->setEstoque($data['stock'])
                ->setImagem($data['image'])
                ->editarPeca();
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

    private static function validateImageExtension(Imagem $image) {
        $extensions = ['png', 'jpeg', 'jpg'];
        if (!in_array($image->extension, $extensions)) {
            throw new \Exception(
                "Invalid extension file. It must be ".\implode(' - ', $extensions).
                "; \"$image->extension\" given."
            );
        }
    }


}