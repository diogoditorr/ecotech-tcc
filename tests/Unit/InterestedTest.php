<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Controllers\EletronicPartsController;
use App\Controllers\InterestedController;
use App\Controllers\PeopleController;
use App\Models\EletronicPart;
use App\Models\Profile;
use PHPUnit\Framework\TestCase;

final class InterestedTest extends TestCase
{
    private static array $fakeData;
    private static Profile $profile;
    private static EletronicPart $eletronicPart;

    public static function setUpBeforeClass(): void
    {
        self::$fakeData = require __DIR__ . '/../Data/fakedata.php';
        self::$profile = PeopleController::loadProfile(cpf: self::$fakeData['people'][0]['cpf']);
        self::$eletronicPart = EletronicPartsController::getFirst();
    }
 
    public function testIsEletronicPartFavorited()
    {
        $result = InterestedController::isEletronicPartFavorited(
            self::$eletronicPart->getId(),
            self::$profile->getPersonId()
        );

        $this->assertFalse($result);
    }

    public function testFavoriteEletronicPart()
    {
        $result = InterestedController::favoriteEletronicPart(
            self::$eletronicPart->getId(),
            self::$profile->getPersonId()
        );

        $this->assertTrue($result);
        $this->assertTrue(
            InterestedController::isEletronicPartFavorited(
                self::$eletronicPart->getId(),
                self::$profile->getPersonId()
            )
        );
    }

    public function testUnfavoriteEletronicPart()
    {
        InterestedController::favoriteEletronicPart(
            self::$eletronicPart->getId(),
            self::$profile->getPersonId()
        );
        $result = InterestedController::unfavoriteEletronicPart(
            self::$eletronicPart->getId(),
            self::$profile->getPersonId()
        );

        $this->assertTrue($result);
        $this->assertFalse(
            InterestedController::isEletronicPartFavorited(
                self::$eletronicPart->getId(),
                self::$profile->getPersonId()
            )
        );
    }

    public function testGetAllByUserId()
    {
        $eletronicParts = EletronicPartsController::getAllByUserId(self::$profile->getPersonId());
        /** @var EletronicPart $eletronicPart */
        foreach ($eletronicParts as $eletronicPart) {
            InterestedController::favoriteEletronicPart(
                $eletronicPart->getId(),
                self::$profile->getPersonId()
            );
        }

        $favoritedEletronicParts = InterestedController::getAllByUserId(self::$profile->getPersonId());

        $this->assertCount(count($eletronicParts), $favoritedEletronicParts);
    }
}
