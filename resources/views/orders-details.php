<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PedidosController;

    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $pedido = PedidosController::getDetailsById($_GET['pedido_id']);

    if ($pedido->getCliente()->getId() != $_SESSION['user_id']) {
        header('Location: ./orders.php');
        exit();
    }

    $title = 'Ecotech | Detalhes do pedido';
    $css['paths'] = [
        '../../public/styles/page-orders-details.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-orders-details">
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
                <span>
                    <p>Pedido</p>
                    <small>#<?=$pedido->getId()?></small>
                </span>

                <a class="back" href="./orders.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$pedido->getPecaEletronica()->getImagem()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            <?=$pedido->getPecaEletronica()->getNome()?>
                        </div>
                        
                        <div class="status">
                            <span>Status:</span>
                            <div class="<?=match ($pedido->getStatus()) {
                                    'pendente' => 'pending',
                                    'entregue' => 'delivered',
                                    'cancelado' => 'cancelled',
                                    default => 'pending'
                                };?>"><?=$pedido->getStatus()?></div>
                        </div>

                        <div class="buttons">
                            <a class="chat" target="_blank"  href="./chat.php">
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
                            <td><?=$pedido->getDoador()->getNome()?></td>
                        </tr>
                        <tr>
                            <td>Endereço</td>
                            <td>
                                NÃO IMPLEMENTADO!!, 
                                <?=$pedido->getDoador()->getEndereco()->getCidade()?> - 
                                <?=$pedido->getDoador()->getEndereco()->getEstado()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Telefone</td>
                            <td>
                                <?=$pedido->getDoador()->getNumTelefone1()?> <br>
                                <?=$pedido->getDoador()->getNumTelefone2()?>
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
                            <td><?=$pedido->getPecaEletronica()->getTipo()?></td>
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td>
                                <?=$pedido->getPecaEletronica()->getModelo()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Sobre</td>
                            <td>
                                <?=$pedido->getPecaEletronica()->getSobre()?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
    

</div>


<?php include('../layouts/footer.php'); ?>