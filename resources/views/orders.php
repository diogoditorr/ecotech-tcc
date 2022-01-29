<?php
    require __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PedidosController;
    use Models\Pedido;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Pedidos';
    $css['paths'] = [
        '../../public/styles/page-orders.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-orders">
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
            <a href="./orders.php" class="active">
                <?php echo file_get_contents("../../public/assets/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php">
                <?php echo file_get_contents("../../public/assets/donation.svg"); ?>
                <span>Doações</span>
            </a>
        </section>

        <section class="content">
            <header>
                <p>Pedidos</p>
            </header>

            <table>
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
                        $pedidos = PedidosController::getAllByClientId($_SESSION['user_id']);
                        
                        /**
                        * @var Pedido $pedido 
                        */
                        foreach ($pedidos as $pedido) {
                            $status = match ($pedido->getStatus()) {
                                'pendente' => 'pending',
                                'entregue' => 'delivered',
                                'cancelado' => 'cancelled',
                                default => 'pending'
                            };

                            echo "
                                <tr>
                                    <td class=\"image\"><img src=\"../../storage/parts/{$pedido->getPecaEletronica()->getImagem()->name}\" alt=\"\"></td>
                                    <td class=\"order-id\">#{$pedido->getId()}</td>
                                    <td class=\"name\">{$pedido->getPecaEletronica()->getNome()}</td>
                                    <td class=\"status {$status}\">{$pedido->getStatus()}</td>
                                    <td class=\"see-details\">
                                        <a href=\"./orders-details.php?pedido_id={$pedido->getId()}\">
                                            <img src=\"../../public/assets/info.svg\" alt=\"\">
                                            <span>Detalhes</span>
                                        </a>
                                    </td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>