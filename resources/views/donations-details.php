<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PedidosController;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $pedido = PedidosController::getDetailsById($_GET['pedido_id']);
    
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
                    <small>#<?=$pedido->getId()?></small>
                </span>

                <a class="back" href="./donations.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$pedido->getPecaEletronica()->getImagem()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <input name="orderId" type="text" value="<?=$pedido->getId()?>" hidden>
                        <div class="name">
                            <?=$pedido->getPecaEletronica()->getNome()?>
                        </div>
                        
                        <div class="status">
                            <span>Status:</span>
                            <select name="status" id="status">
                                <?php
                                    $status = match ($pedido->getStatus()) {
                                        'pendente' => 'pending',
                                        'entregue' => 'delivered',
                                        'cancelado' => 'cancelled',
                                        default => 'pending'
                                    };
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

<!-- <script src="../../public/scripts/donations-details.js" type="module"></script> -->
<script src="../../dist/assets/donations-details.js"></script>

<?php include('../layouts/footer.php'); ?>