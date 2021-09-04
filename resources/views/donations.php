<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PecasEletronicasController;
    use Controllers\PedidosController;
    use Models\PecaEletronica;
    use Models\Pedido;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }
    
    $title = 'Ecotech | Doações';
    $css['locations'] = [
        '../../public/styles/page-donations.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/tables.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations">
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
            <div class="registers">
                <header>
                    <p>Registrados</p>
                    
                    <a class="create-new" href="./donations-new.php">
                        <?php echo file_get_contents("../../public/assets/plus.svg"); ?>
                        <span>Novo</span>
                    </a>
                </header>

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
                            $pecasEletronicas = PecasEletronicasController::getAllByUserId($_SESSION['user_id']);

                            /** 
                            * @var PecaEletronica $peca 
                            */ 
                            foreach ($pecasEletronicas as $peca) {
                                echo "
                                <tr>
                                    <td class=\"image\">
                                        <img 
                                            src=\"../../storage/parts/{$peca->getImagem()->name}\" 
                                            alt=\"Imagem da peça\"
                                        >
                                    </td>
                                    <td class=\"name\">{$peca->getNome()}</td>
                                    <td class=\"stock\">{$peca->getEstoque()}</td>
                                    <td class=\"buttons\">
                                        <div class=\"wrapper\">
                                            <a class=\"edit\" href=\"./donations-edit.php?peca_id={$peca->getId()}\">".
                                                file_get_contents("../../public/assets/edit.svg")."
                                                <span>Editar</span>
                                            </a>
                                            <button class=\"delete\" onclick=\"\">".
                                                file_get_contents('../../public/assets/trash.svg')."
                                            </button>
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
                            $pedidos = PedidosController::getAllByDonorId($_SESSION['user_id']);
                            
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
                                            <a href=\"./donations-details.php\">
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
            </div>
        </section>
    </main>
    

</div>


<?php include('../layouts/footer.php'); ?>