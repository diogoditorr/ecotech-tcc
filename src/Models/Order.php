<?php declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Models\Address;
use App\Models\BaseModel;
use App\Models\EletronicPart;
use App\Models\Image;
use App\Models\Person;

class Order extends BaseModel
{
    protected string $id;
    protected EletronicPart|null $eletronicPart;
    protected Person|null $donor;
    protected Person|null $receiver;
    protected string $status;
    protected string $created_at;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of eletronicPart
     */
    public function getEletronicPart()
    {
        return $this->eletronicPart;
    }

    /**
     * Set the value of eletronicPart
     *
     * @return  self
     */
    public function setEletronicPart($eletronicPart)
    {
        $this->eletronicPart = $eletronicPart;

        return $this;
    }

    /**
     * Get the value of donor
     */
    public function getDonor()
    {
        return $this->donor;
    }

    /**
     * Set the value of donor
     *
     * @return  self
     */
    public function setDonor($donor)
    {
        $this->donor = $donor;

        return $this;
    }

    /**
     * Get the value of receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set the value of receiver
     *
     * @return  self
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    private static function getConnection(): \mysqli
    {
        return Connection::connect();
    }

    private static function fromArray(
        array $data,
        bool $setEletronicPart = false,
        bool $setDonor = false,
        bool $setReceiver = false
    ): Order {
        $eletronicPart = (new EletronicPart())->setId((int) $data['eletronic_part_id']);
        $donor = (new Person())->setId((int) $data['donor_id']);
        $receiver = (new Person())->setId((int) $data['receiver_id']);

        if ($setEletronicPart) {
            $eletronicPart
                ->setPersonId($donor->getId())
                ->setName($data['eletronic_part_name'])
                ->setType($data['eletronic_part_type'])
                ->setModel($data['eletronic_part_model'])
                ->setDescription($data['eletronic_part_description'])
                ->setImage(Image::createByName($data['eletronic_part_image_identifier']))
                ->setStock((int) $data['eletronic_part_stock']);
        }

        if ($setDonor) {
            $donor
                ->setCpf($data['donor_cpf'])
                ->setEmail($data['donor_email'])
                ->setName($data['donor_name'])
                ->setSchool($data['donor_school'])
                ->setPhoneNumber1($data['donor_phone_number_1'])
                ->setPhoneNumber2($data['donor_phone_number_2'])
                ->setAddress(
                    (new Address())
                        ->setAddress($data['donor_address'])
                        ->setCity($data['donor_city'])
                        ->setState($data['donor_state'])
                        ->setDistrict($data['donor_district'])
                        ->setZipCode($data['donor_zip_code'])
                );
        }

        if ($setReceiver) {
            $receiver
                ->setCpf($data['receiver_cpf'])
                ->setEmail($data['receiver_email'])
                ->setName($data['receiver_name'])
                ->setSchool($data['receiver_school'])
                ->setPhoneNumber1($data['receiver_phone_number_1'])
                ->setPhoneNumber2($data['receiver_phone_number_2'])
                ->setAddress(
                    (new Address())
                        ->setAddress($data['receiver_address'])
                        ->setCity($data['receiver_city'])
                        ->setState($data['receiver_state'])
                        ->setDistrict($data['receiver_district'])
                        ->setZipCode($data['receiver_zip_code'])
                );
        }

        return (new Order())
            ->setId($data['id'])
            ->setEletronicPart($eletronicPart)
            ->setDonor($donor)
            ->setReceiver($receiver)
            ->setStatus($data['status'])
            ->setCreatedAt($data['created_at']);
    }

    public function insert()
    {
        $connection = Order::getConnection();
        $query = "
            INSERT INTO `order`
                ( id, eletronic_part_id, donor_id, receiver_id )
            VALUES (
                '{$this->id}',
                '{$this->eletronicPart->getId()}', 
                '{$this->donor->getId()}', 
                '{$this->receiver->getId()}'
            )
        ";

        $connection->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($connection),
                E_USER_ERROR
            );

        $connection->close();

        return true;
    }

    public static function getAllByReceiverId($receiverId)
    {
        $conn = Order::getConnection();

        $query = "
            SELECT
                `order`.id,
                `order`.eletronic_part_id,
                `order`.donor_id,
                `order`.receiver_id,
                `order`.status,
                `order`.created_at,
                eletronic_part.name AS eletronic_part_name,
                eletronic_part.type AS eletronic_part_type,
                eletronic_part.model AS eletronic_part_model,
                eletronic_part.description AS eletronic_part_description,
                eletronic_part.image_identifier AS eletronic_part_image_identifier,
                eletronic_part.stock AS eletronic_part_stock
            FROM `order`
            INNER JOIN eletronic_part
                ON `order`.eletronic_part_id = eletronic_part.id
            WHERE `order`.receiver_id = '{$receiverId}'
            ORDER BY `order`.created_at DESC
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $orders = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($orders, Order::fromArray($data, setEletronicPart: true));
        }

        $conn->close();
        return $orders;
    }

    public static function getAllByDonorId($donorId)
    {
        $conn = Order::getConnection();

        $query = "
            SELECT 
                `order`.id,
                `order`.eletronic_part_id,
                `order`.donor_id,
                `order`.receiver_id,
                `order`.status,
                `order`.created_at,
                eletronic_part.name as eletronic_part_name,
                eletronic_part.type as eletronic_part_type,
                eletronic_part.model as eletronic_part_model,
                eletronic_part.description as eletronic_part_description,
                eletronic_part.image_identifier as eletronic_part_image_identifier,
                eletronic_part.stock as eletronic_part_stock
            FROM `order`
            INNER JOIN eletronic_part 
                ON `order`.eletronic_part_id = eletronic_part.id
            WHERE `order`.donor_id = '{$donorId}'
            ORDER BY `order`.created_at DESC
        ";

        $result = $conn->query($query) or
            trigger_error(
                "Query Failed! SQL: $query - Error: " . mysqli_error($conn),
                E_USER_ERROR
            );

        $orders = [];
        while ($data = $result->fetch_assoc()) {
            if ($data !== null)
                \array_push($orders, Order::fromArray($data, setEletronicPart: true));
        }

        $conn->close();
        return $orders;
    }

    public static function getDetailsById($id)
    {
        $conn = Order::getConnection();

        $query = "
            SELECT 
                `order`.id,
                `order`.eletronic_part_id,
                `order`.donor_id,
                `order`.receiver_id,
                `order`.status,
                `order`.created_at,
                eletronic_part.name as eletronic_part_name,
                eletronic_part.type as eletronic_part_type,
                eletronic_part.model as eletronic_part_model,
                eletronic_part.description as eletronic_part_description,
                eletronic_part.image_identifier as eletronic_part_image_identifier,
                eletronic_part.stock as eletronic_part_stock,
                person_donor.cpf AS donor_cpf,
                person_donor.email AS donor_email,
                person_donor.name AS donor_name,
                person_donor.school as donor_school,
                person_donor.phone_number_1 AS donor_phone_number_1,
                person_donor.phone_number_2 AS donor_phone_number_2,
                address_donor.address AS donor_address,
                address_donor.city AS donor_city,
                address_donor.state AS donor_state,
                address_donor.district AS donor_district,
                address_donor.zip_code AS donor_zip_code,
                person_receiver.cpf AS receiver_cpf,
                person_receiver.email AS receiver_email,
                person_receiver.name AS receiver_name,
                person_receiver.school as receiver_school,
                person_receiver.phone_number_1 AS receiver_phone_number_1,
                person_receiver.phone_number_2 AS receiver_phone_number_2,
                address_receiver.address AS receiver_address,
                address_receiver.city AS receiver_city,
                address_receiver.state AS receiver_state,
                address_receiver.district AS receiver_district,
                address_receiver.zip_code AS receiver_zip_code
            FROM `order`
            INNER JOIN eletronic_part 
                ON `order`.eletronic_part_id = eletronic_part.id
            INNER JOIN person as person_donor
                ON `order`.donor_id = person_donor.id
            INNER JOIN person as person_receiver
                ON `order`.receiver_id = person_receiver.id
            INNER JOIN address as address_donor
                ON `order`.donor_id = address_donor.person_id
            INNER JOIN address as address_receiver
                ON `order`.receiver_id = address_receiver.person_id
            WHERE `order`.id = '{$id}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return null;
        }

        $data = $result->fetch_assoc();

        if ($data === null) {
            $conn->close();
            return null;
        }

        $order = Order::fromArray(
            $data,
            setEletronicPart: true,
            setDonor: true,
            setReceiver: true
        );

        $conn->close();
        return $order;
    }

    public static function changeStatus($id, $status)
    {
        $conn = Order::getConnection();

        $query = "
            UPDATE `order`
            SET status = '{$status}'
            WHERE id = '{$id}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return false;
        }

        $conn->close();
        return true;
    }

    public static function delete($id)
    {
        $conn = Order::getConnection();

        $query = "
            DELETE FROM `order`
            WHERE id = '{$id}'
        ";

        $result = $conn->query($query);

        if (!$result) {
            $conn->close();
            return false;
        }

        $conn->close();
        return true;
    }
}
