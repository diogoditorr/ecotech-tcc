<?php
    $title = 'Ecotech | Interessados';
    $css['locations'] = [
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
                <div class="name">Diego</div>
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
                    <tr>
                        <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                        <td class="order-id">#P9ACN678</td>
                        <td class="name">Semicondutores e transístores</td>
                        <td class="status pending">Pendente</td>
                        <td class="see-details">
                            <a href="./orders-details.php">
                                <img src="../../public/assets/info.svg" alt="">
                                <span>Detalhes</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                        <td class="order-id">#CHJ9K10L</td>
                        <td class="name">Semicondutores e transístores e transístores e transístores e transístores</td>
                        <td class="status delivered">Entregue</td>
                        <td class="see-details">
                            <a href="./orders-details.php">
                                <img src="../../public/assets/info.svg" alt="">
                                <span>Detalhes</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                        <td class="order-id">#WWJ9K10L</td>
                        <td class="name">Semicondutores e transístores e transístores e transístores e transístores</td>
                        <td class="status cancelled">Entregue</td>
                        <td class="see-details">
                            <a href="./orders-details.php">
                                <img src="../../public/assets/info.svg" alt="">
                                <span>Detalhes</span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    

</div>


<?php include('../layouts/footer.php'); ?>