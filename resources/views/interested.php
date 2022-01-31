<?php
    require_once __DIR__ . "/../../vendor/autoload.php";

    use Controllers\InteressadosController;
    use Controllers\PecasEletronicasController;
    use Models\PecaEletronica;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $title = 'Ecotech | Interessados';
    $css['paths'] = [
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
                    <?php
                        $interessados = InteressadosController::getAllByUserId($_SESSION['user_id']);
                        
                        if (count($interessados) > 0) {
                            $pecasEletronicasId = array_reduce($interessados, function($array, $item) {
                                $array[] = $item->getPecaEletronicaId();
                                return $array;
                            });
    
                            $pecasEletronicas = PecasEletronicasController::getAllByIds($pecasEletronicasId);
    
                            /** @var PecaEletronica $pecaEletronica */
                            foreach($pecasEletronicas as $pecaEletronica) {
                                echo "
                                    <tr>
                                        <td 
                                            class=\"image\"><img src=\"../../storage/parts/{$pecaEletronica->getImagem()->name}\" 
                                            alt=\"Part Image\"
                                        ></td>
                                        <td class=\"name\">{$pecaEletronica->getNome()}</td>
                                        <td class=\"see-details\">
                                            <a href=\"./interested-details.php?peca_id={$pecaEletronica->getId()}\">
                                                <img src=\"../../public/assets/info.svg\" alt=\"\">
                                                <span>Detalhes</span>
                                            </a>
                                        </td>
                                    </tr>
                                ";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</div>


<?php include('../layouts/footer.php'); ?>