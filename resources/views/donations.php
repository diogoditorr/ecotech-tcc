<? declare(strict_types=1);
    require_once __DIR__ . '/../../vendor/autoload.php';

    use App\Controllers\EletronicPartsController;
    use App\Controllers\OrdersController;
    use App\Models\EletronicPart;
    use App\Models\Order;
    use App\Php\Util;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $title = 'Ecotech | Doações';
    $css['paths'] = [
        '../../dist/assets/page-donations.css',
        '../../dist/assets/navigation-bar.css',
        '../../dist/assets/navigation-profile.css',
        '../../dist/assets/content-section.css',
        '../../dist/assets/tables.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations">
    <nav>
        <div class="left">
            <img class="logo" src="../../public/svg/logo.svg" alt="">

            <div class="tabs">
                <a href="./explore.php">Explore</a>
                <a class="active" href="#">Profile</a>
            </div>
        </div>

        <div class="right">
            <div class="profile">
                <img class="user-icon" src="../../public/svg/user-icon.svg" alt="User Icon">
                <div class="name"><?= $_SESSION['user_username'] ?></div>
                <img class="dropdown" src="../../public/svg/dropdown.svg" alt="dropdown">
            </div>
        </div>
    </nav>

    <main>
        <section class="navigation-profile">
            <a href="./interested.php">
                <?php echo file_get_contents("../../public/svg/heart.svg"); ?>
                <span>Interessados</span>
            </a>
            <a href="./orders.php">
                <?php echo file_get_contents("../../public/svg/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php" class="active">
                <?php echo file_get_contents("../../public/svg/donation.svg"); ?>
                <span>Doações</span>
            </a>
        </section>

        <section class="content">
            <div class="registers">
                <div>
                    <p>Registrados</p>
                    
                    <a class="create-new" href="./donations-new.php">
                        <?php echo file_get_contents("../../public/svg/plus.svg"); ?>
                        <span>Novo</span>
                    </a>
                </div>

                <table class="table-registers">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nome</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $eletronicParts = EletronicPartsController::getAllByUserId($_SESSION['user_id']);

                            /** 
                            * @var EletronicPart $eletronicPart 
                            */ 
                            foreach ($eletronicParts as $eletronicPart) {
                                echo "
                                <tr>
                                    <td class=\"image\">
                                        <img 
                                            src=\"../../storage/parts/{$eletronicPart->getImage()->name}\" 
                                            alt=\"Imagem da peça\"
                                        >
                                    </td>
                                    <td class=\"name\">{$eletronicPart->getName()}</td>
                                    <td class=\"stock\">{$eletronicPart->getStock()}</td>
                                    <td class=\"buttons\">
                                        <div class=\"wrapper\">
                                            <a class=\"edit\" href=\"./donations-edit.php?eletronicPartId={$eletronicPart->getId()}\">".
                                                file_get_contents("../../public/svg/edit.svg")."
                                                <span>Editar</span>
                                            </a>
                                            <a class=\"delete\" href=\"../../src/php/donations-delete.php?eletronicPartId={$eletronicPart->getId()}\">".
                                                file_get_contents('../../public/svg/trash.svg')."
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="donations">
                <header>
                    <p>Doações</p>
                </header>

                <table class="table-donations">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $orders = OrdersController::getAllByDonorId($_SESSION['user_id']);
                            
                            /**
                            * @var Order $order 
                            */
                            foreach ($orders as $order) {
                                $status = Util::parseStatus($order->getStatus());

                                echo "
                                    <tr>
                                        <td class=\"image\"><img src=\"../../storage/parts/{$order->getEletronicPart()->getImage()->name}\" alt=\"\"></td>
                                        <td class=\"order-id\">#{$order->getId()}</td>
                                        <td class=\"name\">{$order->getEletronicPart()->getName()}</td>
                                        <td class=\"status {$status}\">{$order->getStatus()}</td>
                                        <td class=\"see-details\">
                                            <a href=\"./donations-details.php?orderId={$order->getId()}\">
                                                <img src=\"../../public/svg/info.svg\" alt=\"\">
                                                <span>Detalhes</span>
                                            </a>
                                        </td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>


<?php include('../layouts/footer.php'); ?>