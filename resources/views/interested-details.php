<?php
    require_once __DIR__ . "/../../vendor/autoload.php";

    use Controllers\InteressadosController;
    use Controllers\PecasEletronicasController;
    use Controllers\PessoasController;
    use Models\Interessado;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $pecaEletronica = PecasEletronicasController::getById($_GET['peca_id']);
    if (!isset($pecaEletronica)) {
        http_response_code(404);
        exit();
    }

    $pessoa = PessoasController::getById($pecaEletronica->getPessoaId());

    if (!InteressadosController::isPartFavorited(
            $pecaEletronica->getId(),
            $_SESSION['user_id']
        )) {
        http_response_code(403);
        exit();
    }

    $title = 'Ecotech | Detalhes da peça';
    $css['paths'] = [
        '../../public/styles/page-interested-details.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-interested-details">
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
            <a href="./interested.php" class="active">
                <?php echo file_get_contents("../../public/assets/heart.svg"); ?>
                <span>Interessados</span>
            </a>
            <a href="./orders.php">
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
                <p>Interessados</p>

                <a href="./interested.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$pecaEletronica->getImagem()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            <?=$pecaEletronica->getNome()?>
                        </div>

                        <div class="stock">
                            <span>Estoque:</span>
                            <div class="amount"><?=$pecaEletronica->getEstoque()?> unidades</div>
                        </div>

                        <div class="buttons">
                            <button class="remove-favorite">
                                <?php echo file_get_contents("../../public/assets/heart.svg"); ?>
                                <span>Remover</span>
                            </button>
                            <form action="../../src/php/make-order.php" method="post">
                                <input type="hidden" name="partId" value="<?=$pecaEletronica->getId()?>">
                                <input type="hidden" name="doadorId" value="<?=$pecaEletronica->getPessoaId()?>">
                                <button class="order">
                                    <span>Fazer Pedido</span>
                                </button>
                            </form>
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
                            <td><?=$pessoa->getNome()?></td>
                        </tr>
                        <tr>
                            <td>Endereço</td>
                            <td>
                                <?=$pessoa->getEndereco()->getBairro()?>, 
                                <?=$pessoa->getEndereco()->getCidade()?> - 
                                <?=$pessoa->getEndereco()->getEstado()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Telefone</td>
                            <td>
                                <?=$pessoa->getNumTelefone1()?> <br>
                                <?=$pessoa->getNumTelefone2()?>
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
                            <td><?=$pecaEletronica->getTipo()?></td>
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td>
                                <?=$pecaEletronica->getModelo()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Sobre</td>
                            <td>
                                <?=$pecaEletronica->getSobre()?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>


</div>


<?php include('../layouts/footer.php'); ?>