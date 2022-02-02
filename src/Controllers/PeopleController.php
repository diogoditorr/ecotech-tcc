<?php declare(strict_types=1);


namespace App\Controllers;

use App\Models\Person;
use App\Models\Profile;
use App\Models\Address;

class PeopleController 
{
    public static function registerUser(array $data)
    {
        $dataAlreadyRegistered = Profile::hasDataAlreadyRegistered($data['cpf'], $data['email'], $data['userName']);

        if ($dataAlreadyRegistered) {
            return array(
                "success" => false,
                "error" => "CPF, email ou nome de usuário já cadastrado"
            );
        }

        $registerPersonSuccess = (new Person())
            ->setCpf($data['cpf'])
            ->setEmail($data['email'])
            ->setName($data['fullName'])
            ->setSchool($data['school'])
            ->setPhoneNumber1($data['phoneNumber1'])
            ->setPhoneNumber2(isset($data['phoneNumber2']) ? $data['phoneNumber2'] : "")
            ->insert();

        if ($registerPersonSuccess) {
            $personId = Person::getIdByCpf($data['cpf']);

            $registerProfileSuccess = (new Profile())
                ->setPersonId((int) $personId)
                ->setCpf($data['cpf'])
                ->setEmail($data['email'])
                ->setUserName($data['userName'])
                ->setPassword($data['password'])
                ->insert();

            $registerAddressSuccess = (new Address())
                ->setPersonId((int) $personId)
                ->setAddress($data['address'])
                ->setCity($data['city'])
                ->setState($data['state'])
                ->setDistrict($data['district'])
                ->setZipCode($data['zipCode'])
                ->insert();
        }

        if (!$registerPersonSuccess || !$registerProfileSuccess || !$registerAddressSuccess) {
            return array(
                "success" => false,
                "error" => "Não foi possível registrar no banco de dados"
            );
        }

        return array(
            "success" => true,
            "error" => ""
        );
    }

    public static function loadProfile($personId, $cpf, $email)
    {
        $profile = null;

        if ($personId) {
            $profile = Profile::getBypersonId($personId);

        } else if ($cpf) {
            $profile = Profile::getByCpf($cpf);
            
        } else if ($email) {
            $profile = Profile::getByEmail($email);
        }

        return $profile;
    }

    public static function verifyUserCredentials($cpf, $email, $password) 
    {
        return Profile::verifyUserCredentials($cpf, $email, $password);
    }

    public static function getById(int $id)
    {
        return Person::getById($id);
    }
}