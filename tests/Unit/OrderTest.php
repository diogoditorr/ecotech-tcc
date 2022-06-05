<?php

declare(strict_types=1);

use App\Controllers\EletronicPartsController;
use App\Controllers\OrdersController;
use App\Controllers\PeopleController;
use App\Models\EletronicPart;
use App\Models\Order;
use App\Models\Profile;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    private static array $fakeData;
    private static Profile $firstUser;
    private static Profile $secondUser;
    private static array $secondUserEletronicParts;
    private static ?array $ordersOnDatabase;

    public static function setUpBeforeClass(): void
    {
        self::$fakeData = require __DIR__ . '/../Data/fakedata.php';
        self::$firstUser = PeopleController::loadProfile(cpf: self::$fakeData['people'][0]['cpf']);
        self::$secondUser = PeopleController::loadProfile(cpf: self::$fakeData['people'][1]['cpf']);
        self::$secondUserEletronicParts = EletronicPartsController::getAllByUserId(
            self::$secondUser->getId()
        );
    }

    public function testRequestOrder()
    {
        /** @var EletronicPart $eletronicPart */
        foreach (self::$secondUserEletronicParts as $eletronicPart) {
            $result = OrdersController::requestOrder(
                eletronicPartId: $eletronicPart->getId(),
                donorId: self::$secondUser->getPersonId(),
                receiverId: self::$firstUser->getPersonId(),
            );

            $this->assertTrue($result['success'], (string) $result['error']);
        }
    }

    public function testGetAllByReceiverId()
    {
        $eletronicParts = OrdersController::getAllByReceiverId(self::$firstUser->getPersonId());

        $donorId = self::$fakeData['people'][1]['id'];

        $eletronicPartsOrdered = array_filter(
            self::$fakeData['eletronicParts'],
            function ($eletronicPart) use ($donorId) {
                return $eletronicPart['personId'] === $donorId;
            }
        );

        $this->assertCount(count($eletronicPartsOrdered), $eletronicParts);
    }

    public function testGetAllByDonorId()
    {
        $eletronicParts = OrdersController::getAllByDonorId(self::$secondUser->getPersonId());

        self::$ordersOnDatabase = $eletronicParts;

        $this->assertCount(count(self::$secondUserEletronicParts), $eletronicParts);
    }

    public function testGetDetailsById()
    {
        $orderId = self::$ordersOnDatabase[0]->getId();

        $order = OrdersController::getDetailsById($orderId);

        $this->assertInstanceOf(Order::class, $order);
    }

    public function testChangeStatus()
    {
        $orderId = self::$ordersOnDatabase[0]->getId();

        $result = OrdersController::changeStatus($orderId, 'entregue');

        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $orderId = self::$ordersOnDatabase[0]->getId();

        $result = OrdersController::delete($orderId);

        $this->assertTrue($result);
    }
}
