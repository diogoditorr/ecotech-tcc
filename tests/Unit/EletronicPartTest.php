<?php declare(strict_types=1);

namespace App\Tests\Unit;


use App\Controllers\EletronicPartsController;
use App\Controllers\PeopleController;
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

    public function testGetAllEletronicParts()
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
