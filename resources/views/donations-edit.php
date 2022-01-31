<?php   
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PecasEletronicasController;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }
    
    if (!isset($_GET['peca_id'])) {
        // header('Location: donations.php');
        http_response_code(400);
        exit();
    }
    
    $pecaEletronica = PecasEletronicasController::getById($_GET['peca_id']);
    if ($pecaEletronica == null) {
        // header('Location: donations.php');
        http_response_code(404);
        exit();
    }

    $title = 'Ecotech | Editando peça';
    $css['paths'] = [
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
            <form action="../../src/php/donations-edit.php" method="post" enctype="multipart/form-data">
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

                    <input type="number" name="id" value="<?=$pecaEletronica->getId()?>" hidden>
                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" value="<?=$pecaEletronica->getNome()?>" required>
                    </div>
                    <div class="field">
                        <label for="type">Tipo</label>
                        <input type="text" name="type" id="type" value="<?=$pecaEletronica->getTipo()?>" required>
                    </div>
                    <div class="field">
                        <label for="model">Modelo</label>
                        <input type="text" name="model" id="model" value="<?=$pecaEletronica->getModelo()?>" required>
                    </div>
                    <div class="field">
                        <label for="about">Sobre</label>
                        <textarea name="about" id="about" cols="30" rows="10" required><?=$pecaEletronica->getSobre()?></textarea>
                    </div>

                    <div class="field">
                        <label for="stock">Quantidade em estoque</label>

                        <div class="stock-menu">
                            <button class="subtract">
                                <?php echo file_get_contents("../../public/assets/arrow-left-stock-menu.svg"); ?>
                            </button>
                            <input type="number" name="stock" id="stock" value="<?=$pecaEletronica->getEstoque()?>" required>
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
                            <img src="../../storage/parts/<?=$pecaEletronica->getImagem()->name?>" alt="">
                        </div>
                    </div>

                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
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

                    <a class="delete" href="../../src/php/donations-delete.php?partId=<?=$pecaEletronica->getId()?>">
                        <?php echo file_get_contents("../../public/assets/trash.svg"); ?>
                        <span>Excluir</span>
                    </a>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="../../dist/assets/stock-menu.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>