<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Controllers\PeopleController;
use App\Models\Profile;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use PHPUnit\Framework\TestCase;

final class RegisterTest extends TestCase
{
    private static array $fakeData;
    private static Client $client;

    public static function setUpBeforeClass(): void
    {
        self::$fakeData = require __DIR__ . '/../Data/fakedata.php';
        self::$client = new \GuzzleHttp\Client([
            'base_uri' => "{$_ENV['SERVER_HOST']}:{$_ENV['SERVER_PORT']}",
            'cookies' => true
        ]);
    }

    public function testRegisterFirstUser()
    {
        $result = PeopleController::registerUser(self::$fakeData['people']['1']);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testCanNotRegisterUserWithAlreadyRegisteredData()
    {
        $result = PeopleController::registerUser([
            ...self::$fakeData['people']['1'],
            'email' => self::$fakeData['people'][1]['email'],
            'cpf' => self::$fakeData['people'][1]['cpf'],
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...self::$fakeData['people']['1'],
            'userName' => self::$fakeData['people']['2']['userName'],
            'cpf' => self::$fakeData['people']['2']['cpf'],
        ]);
        $this->assertFalse($result['success']);

        $result = PeopleController::registerUser([
            ...self::$fakeData['people']['1'],
            'userName' => self::$fakeData['people']['2']['userName'],
            'email' => self::$fakeData['people']['2']['email'],
        ]);
        $this->assertFalse($result['success']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testSignInFirstUser()
    {
        $response = self::$client->post('src/php/sign-in.php', [
            'http_errors' => false,
            'json' => [
                'emailCpf' => self::$fakeData['people']['1']['cpf'],
                'password' => self::$fakeData['people']['1']['password'],
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testRegisterSecondUser()
    {
        $result = PeopleController::registerUser(self::$fakeData['people']['2']);

        $this->assertTrue($result['success'], (string) $result['error']);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testLoadProfileByCpf()
    {
        $profile = PeopleController::loadProfile(cpf: self::$fakeData['people']['1']['cpf']);

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
            email: self::$fakeData['people']['1']['email']
        );

        $this->assertInstanceOf(Profile::class, $profile);
    }

    /**
     * @depends testRegisterFirstUser
     */
    public function testVerifyUserCredentials()
    {
        $result = PeopleController::verifyUserCredentials(
            cpf: self::$fakeData['people']['1']['cpf'],
            password: self::$fakeData['people']['1']['password']
        );

        $this->assertInstanceOf(Profile::class, $result);

        $result = PeopleController::verifyUserCredentials(
            email: self::$fakeData['people']['1']['email'],
            password: self::$fakeData['people']['1']['password']
        );

        $this->assertInstanceOf(Profile::class, $result);
    }

    /**
     * @depends testRegisterFirstUser
     * @depends testSignInFirstUser
     */
    public function testRegisterEletronicPart()
    {
        $response = self::$client->post('src/php/donations-new.php', [
            'http_errors' => false,
            'multipart' => [
                [
                    'name' => 'name',
                    'contents' => self::$fakeData['eletronicParts']['1']['name']
                ],
                [
                    'name' => 'type',
                    'contents' => self::$fakeData['eletronicParts']['1']['type']
                ],
                [
                    'name' => 'model',
                    'contents' => self::$fakeData['eletronicParts']['1']['model']
                ],
                [
                    'name' => 'description',
                    'contents' => self::$fakeData['eletronicParts']['1']['description']
                ],
                [
                    'name' => 'stock',
                    'contents' => self::$fakeData['eletronicParts']['1']['stock']
                ],
                [
                    'name' => 'image',
                    'contents' => Psr7\Utils::tryFopen(self::$fakeData['eletronicParts']['1']['image_path'], 'r')
                ]
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
