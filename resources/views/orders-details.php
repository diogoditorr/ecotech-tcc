<?php declare(strict_types=1);
    require_once __DIR__ . '/../../vendor/autoload.php';

    use App\Controllers\OrdersController;
    use App\Php\Util;

    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $order = OrdersController::getDetailsById($_GET['orderId']);

    if ($order->getReceiver()->getId() != $_SESSION['user_id']) {
        header('Location: ./orders.php');
        exit();
    }

    $title = 'Ecotech | Detalhes do pedido';
    $css['paths'] = [
        '../../dist/assets/page-orders-details.css',
        '../../dist/assets/navigation-bar.css',
        '../../dist/assets/navigation-profile.css',
        '../../dist/assets/content-section.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-orders-details">
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
            <a href="./orders.php" class="active">
                <?php echo file_get_contents("../../public/svg/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php">
                <?php echo file_get_contents("../../public/svg/donation.svg"); ?>
                <span>Doações</span>
            </a>
        </section>

        <section class="content">
            <header>
                <span>
                    <p>Pedido</p>
                    <small>#<?=$order->getId()?></small>
                </span>

                <a class="back" href="./orders.php">
                    <?php echo file_get_contents("../../public/svg/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$order->getEletronicPart()->getImage()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            <?=$order->getEletronicPart()->getName()?>
                        </div>
                        
                        <div class="status">
                            <span>Status:</span>
                            <div 
                                class="<?=Util::parseStatus($order->getStatus())?>"
                            >
                                <?=$order->getStatus()?>
                            </div>
                        </div>

                        <div class="buttons">
                            <a class="chat" target="_blank"  href="./chat.php">
                                <?php echo file_get_contents("../../public/svg/chat.svg"); ?>
                                <span>Bate Papo</span>
                            </a>
                            <a class="whatsapp" target="_blank" href="#">
                                <?php echo file_get_contents("../../public/svg/whatsapp.svg"); ?>
                                <span>Entrar em Contato</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Contato</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nome</td>
                            <td><?=$order->getDonor()->getName()?></td>
                        </tr>
                        <tr>
                            <td>Endereço</td>
                            <td>
                                <?=$order->getDonor()->getAddress()->getAddress().', '.
                                   $order->getDonor()->getAddress()->getDistrict()?>, 
                                <?=$order->getDonor()->getAddress()->getCity()?> - 
                                <?=$order->getDonor()->getAddress()->getState()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Telefone</td>
                            <td>
                                <?=$order->getDonor()->getPhoneNumber1()?> <br>
                                <?=$order->getDonor()->getPhoneNumber2()?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>Detalhes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tipo</td>
                            <td><?=$order->getEletronicPart()->getType()?></td>
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td>
                                <?=$order->getEletronicPart()->getModel()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Sobre</td>
                            <td>
                                <?=$order->getEletronicPart()->getDescription()?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>