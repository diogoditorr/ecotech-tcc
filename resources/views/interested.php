<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Interessados';
    $css['locations'] = [
        '../../public/styles/page-interested.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-interested">
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
            </header>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                        <td class="name">Semicondutores e transístores</td>
                        <td class="see-details">
                            <a href="./interested-details.php">
                                <img src="../../public/assets/info.svg" alt="">
                                <span>Detalhes</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="image"><img src="../../storage/parts/image_1.png" alt=""></td>
                        <td class="name">Semicondutores e transístores e transístores e transístores e transístores</td>
                        <td class="see-details">
                            <a href="./interested-details.php">
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