<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }
    
    $title = 'Ecotech | Detalhes da doação';
    $css['locations'] = [
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
                    <small>#P9ACN678</small>
                </span>

                <a class="back" href="./donations.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/image_1.png" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            Semicondutores e transístores
                        </div>
                        
                        <div class="status">
                            <span>Status:</span>
                            <select name="status" id="status">
                                <option value="pending">Pendente</option>
                                <option value="delivered">Entregue</option>
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


<?php include('../layouts/footer.php'); ?>