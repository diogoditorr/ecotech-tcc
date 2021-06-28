<?php
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
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="stock">4</td>
                            <td class="buttons">
                                <div class="wrapper">
                                    <a class="edit" href="./donations-edit.php">
                                    <?php echo file_get_contents("../../public/assets/edit.svg"); ?>
                                        <span>Editar</span>
                                    </a>
                                    <button class="delete" onclick="">
                                        <?php echo file_get_contents('../../public/assets/trash.svg'); ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
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
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="order-id">#P9ACN678</td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="status pending">Pendente</td>
                            <td class="see-details">
                                <a href="./donations-details.php">
                                    <img src="../../public/assets/info.svg" alt="">
                                    <span>Detalhes</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="order-id">#CHJ9K10L</td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="status delivered">Entregue</td>
                            <td class="see-details">
                                <a href="./donations-details.php">
                                    <img src="../../public/assets/info.svg" alt="">
                                    <span>Detalhes</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="order-id">#WWJ9K10L</td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="status cancelled">Cancelado</td>
                            <td class="see-details">
                                <a href="./donations-details.php">
                                    <img src="../../public/assets/info.svg" alt="">
                                    <span>Detalhes</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="order-id">#WWJ9K10L</td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="status cancelled">Cancelado</td>
                            <td class="see-details">
                                <a href="./donations-details.php">
                                    <img src="../../public/assets/info.svg" alt="">
                                    <span>Detalhes</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                            <td class="order-id">#WWJ9K10L</td>
                            <td class="name">Semicondutores e transístores</td>
                            <td class="status cancelled">Cancelado</td>
                            <td class="see-details">
                                <a href="./donations-details.php">
                                    <img src="../../public/assets/info.svg" alt="">
                                    <span>Detalhes</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    

</div>


<?php include('../layouts/footer.php'); ?>