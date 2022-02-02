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
    
    $title = 'Ecotech | Detalhes da doação';
    $css['paths'] = [
        '../../public/styles/page-donations-details.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations-details">
    <nav>
        <div class="left">
            <img class="logo" src="../../public/assets/logo.svg" alt="">

            <div class="tabs">
                <a href="./explore.php">Explore</a>
                <a class="active" href="#">Profile</a>
            </div>
        </div>

        <div class="right">
            <div class="profile">
                <img class="user-icon" src="../../public/assets/user-icon.svg" alt="User Icon">
                <div class="name"><?= $_SESSION['user_username'] ?></div>
                <img class="dropdown" src="../../public/assets/dropdown.svg" alt="dropdown">
            </div>
        </div>
    </nav>

    <main>
        <section class="navigation-profile">
            <a href="./interested.php">
                <?php echo file_get_contents("../../public/assets/heart.svg"); ?>
                <span>Interessados</span>
            </a>
            <a href="./orders.php">
                <?php echo file_get_contents("../../public/assets/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php" class="active">
                <?php echo file_get_contents("../../public/assets/donation.svg"); ?>
                <span>Doações</span>
            </a>
        </section>

        <section class="content">
            <header>
                <span>
                    <p>Doação</p>
                    <small>#<?=$order->getId()?></small>
                </span>

                <a class="back" href="./donations.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$order->getEletronicPart()->getImage()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <input name="orderId" type="text" value="<?=$order->getId()?>" hidden>
                        <div class="name">
                            <?=$order->getEletronicPart()->getName()?>
                        </div>
                        
                        <div class="status">
                            <span>Status:</span>
                            <select name="status" id="status">
                                <?php
                                    $status = Util::parseStatus($order->getStatus());
                                    $options = [
                                        "pending" => "<option value=\"pending\" REPLACE>Pendente</option>",
                                        "delivered" => "<option value=\"delivered\" REPLACE>Entregue</option>",
                                        "cancelled" => "<option value=\"cancelled\" REPLACE>Cancelado</option>"
                                    ];
                                    foreach ($options as $statusCase => $option) {
                                        if ($statusCase == $status) {
                                            echo str_replace("REPLACE", "selected", $option);
                                        } else {
                                            echo str_replace("REPLACE", "", $option);
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="buttons">
                            <div class="field">
                                <button class="save">
                                    <?php echo file_get_contents("../../public/assets/disk.svg"); ?>
                                    <span>Salvar</span>
                                </button>
                                <button class="cancel-order">
                                    <?php echo file_get_contents("../../public/assets/trash.svg"); ?>
                                    <span>Cancelar Pedido</span>
                                </button>
                            </div>
                            <div class="field">
                                <a class="chat" target="_blank" href="./chat.php">
                                    <?php echo file_get_contents("../../public/assets/chat.svg"); ?>
                                    <span>Bate Papo</span>
                                </a>
                                <a class="whatsapp" target="_blank" href="#">
                                    <?php echo file_get_contents("../../public/assets/whatsapp.svg"); ?>
                                    <span>Entrar em Contato</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
</div>

<script src="../../dist/assets/donations-details.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>