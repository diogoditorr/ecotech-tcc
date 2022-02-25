<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\PeopleController;
use App\Models\Profile;

class RegisterTest extends TestCase
{
    private array $fakeData;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fakeData = include __DIR__ . '/../fakedata.php';
    }

    public function testRegisterUser()
    {
        $result = PeopleController::registerUser($this->fakeData['person1']);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    public function testCanNotRegisterUserWithAlreadyRegisteredData()
    {
        $result = PeopleController::registerUser([
            ...$this->fakeData['person1'],
            'email' => 'test2@hotmail.com',
            'cpf' => '0123456789',
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...$this->fakeData['person1'],
            'userName' => 'user2',
            'cpf' => '0123456789',
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...$this->fakeData['person1'],
            'userName' => 'user2',
            'email' => 'test2@hotmail.com',
        ]);
        $this->assertFalse($result['success']);
    }

    public function testLoadProfileByCpf()
    {
        $profile = PeopleController::loadProfile(cpf: $this->fakeData['person1']['cpf']);

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

    public function testLoadProfileByEmail()
    {
        $profile = PeopleController::loadProfile(
            email: $this->fakeData['person1']['email']
        );

        $this->assertInstanceOf(Profile::class, $profile);
    }

    public function testVerifyUserCredentials()
    {
        $result = PeopleController::verifyUserCredentials(
            cpf: $this->fakeData['person1']['cpf'],
            password: $this->fakeData['person1']['password']
        );

        $this->assertInstanceOf(Profile::class, $result);

        $result = PeopleController::verifyUserCredentials(
            email: $this->fakeData['person1']['email'],
            password: $this->fakeData['person1']['password']
        );

        $this->assertInstanceOf(Profile::class, $result);
    }

    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @depends testExample
     */
    public function testExampleTwo()
    {
        $this->assertTrue(true);
    }
}
