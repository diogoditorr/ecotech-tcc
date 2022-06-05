<?php

declare(strict_types=1);

namespace App\Tests\Unit;


use App\Controllers\EletronicPartsController;
use App\Controllers\PeopleController;
use App\Models\EletronicPart;
use PHPUnit\Framework\TestCase;

final class EletronicPartTest extends TestCase
{
    private static array $fakeData;

    public static function setUpBeforeClass(): void
    {
        self::$fakeData = require __DIR__ . '/../Data/fakedata.php';
    }

    public function testRegisterEletronicParts()
    {
        foreach (self::$fakeData['eletronicParts'] as $eletronicPart) {
            $personIndex = array_search($eletronicPart['personId'], array_column(self::$fakeData['people'], 'id'));
            $profile = PeopleController::loadProfile(cpf: self::$fakeData['people'][$personIndex]['cpf']);

            $eletronicPart['image'] = EletronicPartsController::formatImage($eletronicPart['image']);
            $result = EletronicPartsController::register([...$eletronicPart, 'userId' => $profile->getId()]);

            $this->assertTrue($result['success'], (string) $result['error']);
        }
    }

    public function testGetFirst()
    {
        $eletronicPart = EletronicPartsController::getFirst();

        $this->assertTrue($eletronicPart instanceof EletronicPart);
    }

    public function testGetAll()
    {
        $eletronicParts = EletronicPartsController::getAll();

        $this->assertCount(count(self::$fakeData['eletronicParts']), $eletronicParts);
    }

    public function testGetAllByName()
    {
        $eletronicParts = EletronicPartsController::getAllByName('Computador');

        $this->assertCount(3, $eletronicParts);
    }

    public function testGetAllByUserId()
    {
        $profile = PeopleController::loadProfile(cpf: self::$fakeData['people'][0]['cpf']);

        $eletronicPartsOnMock = array_filter(self::$fakeData['eletronicParts'], function ($eletronicPart) {
            return $eletronicPart['personId'] === self::$fakeData['people'][0]['id'];
        });

        $eletronicPartsOnDatabase = EletronicPartsController::getAllByUserId($profile->getPersonId());

        $this->assertEquals(count($eletronicPartsOnMock), count($eletronicPartsOnDatabase));
    }

    public function testGetAllByIds()
    {
        $eletronicParts = EletronicPartsController::getAll();
        $filteredEletronicParts = EletronicPartsController::getAllByIds([
            $eletronicParts[0]->getId(),
            $eletronicParts[1]->getId(),
        ]);

        $this->assertCount(2, $filteredEletronicParts);
    }

    public function testGetById()
    {
        $eletronicPart = EletronicPartsController::getFirst();
        $filteredEletronicPart = EletronicPartsController::getById($eletronicPart->getId());

        $this->assertEquals($eletronicPart->getId(), $filteredEletronicPart->getId());
    }

    public function testEdit()
    {
        $eletronicPart = EletronicPartsController::getFirst();

        $eletronicPart->setName('Computador Ultra Rápido');

        $result = EletronicPartsController::edit([
            'id' => $eletronicPart->getId(),
            'userId' => $eletronicPart->getPersonId(),
            'name' => $eletronicPart->getName(),
            'type' => $eletronicPart->getType(),
            'model' => $eletronicPart->getModel(),
            'description' => $eletronicPart->getDescription(),
            'stock' => $eletronicPart->getStock(),
            'image' => null,
        ]);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    public function testUpdateStock()
    {
        $eletronicPart = EletronicPartsController::getFirst();

        $result = EletronicPartsController::updateStock($eletronicPart->getId(), $eletronicPart->getStock() + 1);

        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $eletronicPart = EletronicPartsController::getFirst();

        $result = EletronicPartsController::delete($eletronicPart->getId());

        $this->assertTrue($result);
        $this->assertNull(EletronicPartsController::getById($eletronicPart->getId()));
    }

    public function testErrorOnImageFormat()
    {
        $result1 = EletronicPartsController::register([
            'image' => null
        ]);

        $result2 = EletronicPartsController::register([
            'image' => []
        ]);

        $result3 = EletronicPartsController::register([
            'image' => '123'
        ]);

        $this->assertFalse($result1['success']);
        $this->assertFalse($result2['success']);
        $this->assertFalse($result3['success']);
    }

    public function testInvalidateIncorrectImageExtension()
    {
        $image = EletronicPartsController::formatImage([
            'name' => 'test.php',
            'type' => 'image/php',
            'tmp_name' => __DIR__ . '/../Data/test.php',
        ]);

        $result = EletronicPartsController::register([
            'image' => $image,
        ]);

        $this->assertFalse($result['success'], (string) $result['error']);

        $image = EletronicPartsController::formatImage([
            'name' => 'test.txt',
            'type' => 'image/text',
            'tmp_name' => __DIR__ . '/../Data/test.txt',
        ]);

        $result = EletronicPartsController::register([
            'image' => $image,
        ]);

        $this->assertFalse($result['success'], (string) $result['error']);
    }
}
