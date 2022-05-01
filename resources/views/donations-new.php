<?php declare(strict_types=1);
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Novo cadastro de peça';
    $css['paths'] = [
        '../../public/styles/page-donations-new.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations-new">
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
            <form action="../../src/php/donations-new.php" method="post" enctype="multipart/form-data">
                <div class="header">
                    <?php echo file_get_contents("../../public/assets/gear.svg"); ?>

                    <span>
                        <h1>Cadastar nova peça</h1>
                        <small>Preencha os campos abaixo para começar a compartilhar!</small>
                    </span>

                    <a class="back" href="./donations.php">
                        <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                    </a>
                </div>

                <fieldset>
                    <legend>Dados</legend>

                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="field">
                        <label for="type">Tipo</label>
                        <input type="text" name="type" id="type" required>
                    </div>
                    <div class="field">
                        <label for="model">Modelo</label>
                        <input type="text" name="model" id="model" required>
                    </div>
                    <div class="field">
                        <label for="description">Sobre</label>
                        <textarea name="description" id="description" cols="30" rows="10" required></textarea>
                    </div>

                    <div class="field">
                        <label for="stock">Quantidade em estoque</label>
                        
                        <div class="stock-menu">
                            <button class="subtract">
                                <?php echo file_get_contents("../../public/assets/arrow-left-stock-menu.svg"); ?>
                            </button>
                            <input type="number" name="stock" id="stock" value="0">
                            <button class="add">
                                <?php echo file_get_contents("../../public/assets/arrow-right-stock-menu.svg"); ?>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Imagem</legend>

                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </fieldset>

                <div class="footer">
                    <button type="submit">
                        <span>Confirmar</span>
                    </button>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="../../dist/assets/stock-menu.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>