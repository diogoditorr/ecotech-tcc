<?php declare(strict_types=1);
    require_once __DIR__ . '/../../vendor/autoload.php';

    use App\Controllers\EletronicPartsController;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }
    
    if (!isset($_GET['eletronicPartId'])) {
        // header('Location: donations.php');
        http_response_code(400);
        exit();
    }
    
    $eletronicPart = EletronicPartsController::getById(
        (int) $_GET['eletronicPartId']
    );
    if ($eletronicPart == null) {
        // header('Location: donations.php');
        http_response_code(404);
        exit();
    }

    $title = 'Ecotech | Editando peça';
    $css['paths'] = [
        '../../dist/assets/page-donations-edit.css',
        '../../dist/assets/navigation-bar.css',
        '../../dist/assets/navigation-profile.css',
        '../../dist/assets/content-section.css',
        '../../dist/assets/image-selector.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-donations-edit">
    <nav>
        <div class="left">
            <img class="logo" src="../../public/svg/logo.svg" alt="">

            <div class="tabs">
                <a href="./explore.php">Explore</a>
                <a class="active" href="#">Profile</a>
            </div>
        </div>

        <div class="right">
            <div class="profile">
                <img class="user-icon" src="../../public/svg/user-icon.svg" alt="User Icon">
                <div class="name"><?= $_SESSION['user_username'] ?></div>
                <img class="dropdown" src="../../public/svg/dropdown.svg" alt="dropdown">
            </div>
        </div>
    </nav>

    <main>
        <section class="navigation-profile">
            <a href="./interested.php">
                <?php echo file_get_contents("../../public/svg/heart.svg"); ?>
                <span>Interessados</span>
            </a>
            <a href="./orders.php">
                <?php echo file_get_contents("../../public/svg/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php" class="active">
                <?php echo file_get_contents("../../public/svg/donation.svg"); ?>
                <span>Doações</span>
            </a>
        </section>

        <section class="content">
            <form action="../../src/php/donations-edit.php" method="post" enctype="multipart/form-data">
                <div class="header">
                    <?php echo file_get_contents("../../public/svg/gear.svg"); ?>

                    <span>
                        <h1>Editar peça registrada</h1>
                        <small>Para modificar, basta editar qualquer um dos campos e salvar</small>
                    </span>

                    <a class="back" href="./donations.php">
                        <?php echo file_get_contents("../../public/svg/arrow-left-small.svg"); ?>
                    </a>
                </div>

                <fieldset>
                    <legend>Dados</legend>

                    <input type="number" name="id" value="<?=$eletronicPart->getId()?>" hidden>
                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" value="<?=$eletronicPart->getName()?>" required>
                    </div>
                    <div class="field">
                        <label for="type">Tipo</label>
                        <input type="text" name="type" id="type" value="<?=$eletronicPart->getType()?>" required>
                    </div>
                    <div class="field">
                        <label for="model">Modelo</label>
                        <input type="text" name="model" id="model" value="<?=$eletronicPart->getModel()?>" required>
                    </div>
                    <div class="field">
                        <label for="description">Sobre</label>
                        <textarea name="description" id="description" cols="30" rows="10" required><?=$eletronicPart->getDescription()?></textarea>
                    </div>

                    <div class="field">
                        <label for="stock">Quantidade em estoque</label>

                        <div class="stock-menu">
                            <button class="subtract">
                                <?php echo file_get_contents("../../public/svg/arrow-left-stock-menu.svg"); ?>
                            </button>
                            <input type="number" name="stock" id="stock" value="<?=$eletronicPart->getStock()?>" required>
                            <button class="add">
                                <?php echo file_get_contents("../../public/svg/arrow-right-stock-menu.svg"); ?>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Imagem</legend>

                    <div class="image-selector">
                        <div class="preview">
                            <img src="../../storage/parts/<?=$eletronicPart->getImage()->name?>"/>
                        </div>
                        <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                        <label for="image">
                            <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.7689 10.5667C21.1233 10.5667 21.4124 10.688 21.6363 10.9305C21.8788 11.1543 22 11.4434 22 11.7979C22 12.1523 21.8788 12.4507 21.6363 12.6932C21.4124 12.917 21.1233 13.029 20.7689 13.029H12.2311V21.5388C12.2311 21.8932 12.1099 22.1916 11.8674 22.4341C11.6435 22.6766 11.3544 22.7979 11 22.7979C10.6456 22.7979 10.3471 22.6766 10.1047 22.4341C9.88081 22.1916 9.7689 21.8932 9.7689 21.5388V13.029H1.2311C0.876696 13.029 0.578246 12.917 0.335756 12.6932C0.111919 12.4507 0 12.1523 0 11.7979C0 11.4434 0.111919 11.1543 0.335756 10.9305C0.578246 10.688 0.876696 10.5667 1.2311 10.5667H9.7689V2.02896C9.7689 1.67455 9.88081 1.38543 10.1047 1.16159C10.3471 0.919097 10.6456 0.797852 11 0.797852C11.3544 0.797852 11.6435 0.919097 11.8674 1.16159C12.1099 1.38543 12.2311 1.67455 12.2311 2.02896V10.5667H20.7689Z" fill="#848D00" />
                            </svg>

                            Selecione uma imagem
                        </label>
                        <button type="button">
                            <svg width="16" height="16" viewBox="0 0 28 28" fill="#ff3b3b" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28 2.82L25.18 0L14 11.18L2.82 0L0 2.82L11.18 14L0 25.18L2.82 28L14 16.82L25.18 28L28 25.18L16.82 14L28 2.82Z" />
                            </svg>
                            <span>
                                Remover imagem
                            </span>
                        </button>
                    </div>
                </fieldset>

                <div class="footer">
                    <button class="save" type="submit">
                        <?php echo file_get_contents("../../public/svg/disk.svg"); ?>
                        <span>Salvar</span>
                    </button>

                    <a class="cancel" href="./donations.php">
                        <?php echo file_get_contents("../../public/svg/close.svg"); ?>
                        <span>Cancelar</span>
                    </a>

                    <a class="delete" href="../../src/php/donations-delete.php?partId=<?=$eletronicPart->getId()?>">
                        <?php echo file_get_contents("../../public/svg/trash.svg"); ?>
                        <span>Excluir</span>
                    </a>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="../../dist/assets/stock-menu.js" type="module"></script>
<script src="../../dist/assets/image-selector.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>