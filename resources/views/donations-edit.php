<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Editando peça';
    $css['locations'] = [
        '../../public/styles/page-donations-edit.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations-edit">
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
            <form action="./explore.php" method="post">

                <div class="header">
                    <?php echo file_get_contents("../../public/assets/gear.svg"); ?>

                    <span>
                        <h1>Editar peça registrada</h1>
                        <small>Para modificar, basta editar qualquer um dos campos e salvar</small>
                    </span>

                    <a class="back" href="./donations.php">
                        <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                    </a>
                </div>

                <fieldset>
                    <legend>Dados</legend>

                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" value="Semicondutores e transístores" required>
                    </div>
                    <div class="field">
                        <label for="type">Tipo</label>
                        <input type="text" name="type" id="type" value="Semicondutores e transítores" required>
                    </div>
                    <div class="field">
                        <label for="model">Modelo</label>
                        <input type="text" name="model" id="model" value="ON Semiconductor - NCV303LSN15T1G / NA Transistor - 2N2222A" required>
                    </div>
                    <div class="field">
                        <label for="about">Sobre</label>
                        <textarea name="about" id="about" cols="30" rows="10">Os componentes eletrônicos são todos os elementos que compõem a estrutura de um circuito elétrico, ou seja, fazem parte de todo circuito eletrônico ou elétrico e estão sempre ligados entre si, formando um sequencial de funções, interligando todos os componentes e fornecendo um trabalho conjunto onde um interfere no funcionamento do outro.
                        </textarea>
                    </div>

                    <div class="field">
                        <label for="stock">Quantidade em estoque</label>

                        <div class="stock-menu">
                            <button class="subtract">
                                <?php echo file_get_contents("../../public/assets/arrow-left-stock-menu.svg"); ?>
                            </button>
                            <input type="number" name="stock" id="stock" value="4">
                            <button class="add">
                                <?php echo file_get_contents("../../public/assets/arrow-right-stock-menu.svg"); ?>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Imagem</legend>

                    <div class="container-image">
                        <div class="image">
                            <img src="../../storage/parts/image_1.png" alt="">
                        </div>
                    </div>

                    <input type="file">
                </fieldset>

                <div class="footer">
                    <button class="save" type="submit">
                        <?php echo file_get_contents("../../public/assets/disk.svg"); ?>
                        <span>Salvar</span>
                    </button>

                    <a class="cancel" href="./donations.php">
                        <?php echo file_get_contents("../../public/assets/close.svg"); ?>
                        <span>Cancelar</span>
                    </a>

                    <button class="delete" type="submit">
                        <?php echo file_get_contents("../../public/assets/trash.svg"); ?>
                        <span>Excluir</span>
                    </button>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="../../public/scripts/stock-menu.js"></script>

<?php include('../layouts/footer.php'); ?>