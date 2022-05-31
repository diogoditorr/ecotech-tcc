<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Controllers\PeopleController;
use App\Models\Profile;
use PHPUnit\Framework\TestCase;

final class PeopleTest extends TestCase
{
    private static array $fakeData;

    public static function setUpBeforeClass(): void
    {
        self::$fakeData = require __DIR__ . '/../Data/fakedata.php';
    }

    public function testRegisterFirstUser()
    {
        $result = PeopleController::registerUser(self::$fakeData['people'][0]);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testCanNotRegisterUserWithAlreadyRegisteredData()
    {
        $result = PeopleController::registerUser([
            ...self::$fakeData['people'][0],
            'email' => self::$fakeData['people'][1]['email'],
            'cpf' => self::$fakeData['people'][1]['cpf'],
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...self::$fakeData['people'][0],
            'userName' => self::$fakeData['people'][1]['userName'],
            'cpf' => self::$fakeData['people'][1]['cpf'],
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...self::$fakeData['people'][0],
            'userName' => self::$fakeData['people'][1]['userName'],
            'email' => self::$fakeData['people'][1]['email'],
        ]);
        $this->assertFalse($result['success']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testRegisterSecondUser()
    {
        $result = PeopleController::registerUser(self::$fakeData['people'][1]);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testLoadProfileByCpf()
    {
        $profile = PeopleController::loadProfile(cpf: self::$fakeData['people'][0]['cpf']);

        $this->assertInstanceOf(Profile::class, $profile);

        return $profile;
    }

    /**
     * @depends testLoadProfileByCpf
     */
    public function testLoadProfileById(Profile $profile)
    {
        $profileById = PeopleController::loadProfile(
            personId: $profile->getId()
        );

        $this->assertInstanceOf(Profile::class, $profileById);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testLoadProfileByEmail()
    {
        $profile = PeopleController::loadProfile(
            email: self::$fakeData['people'][0]['email']
        );

        $this->assertInstanceOf(Profile::class, $profile);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testVerifyUserCredentials()
    {
        $result = PeopleController::verifyUserCredentials(
            cpf: self::$fakeData['people'][0]['cpf'],
            password: self::$fakeData['people'][0]['password']
        );

        $this->assertInstanceOf(Profile::class, $result);

        $result = PeopleController::verifyUserCredentials(
            email: self::$fakeData['people'][0]['email'],
            password: self::$fakeData['people'][0]['password']
        );

        $this->assertInstanceOf(Profile::class, $result);
    }
}
