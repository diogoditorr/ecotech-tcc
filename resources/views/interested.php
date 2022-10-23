<?php declare(strict_types=1);
    require_once __DIR__ . "/../../vendor/autoload.php";

    use App\Controllers\InterestedController;
    use App\Controllers\EletronicPartsController;
    use App\Models\EletronicPart;
    use App\Models\Interested;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }

    $title = 'Ecotech | Interessados';
    $css['paths'] = [
        '../../dist/assets/page-interested.css',
        '../../dist/assets/navigation-bar.css',
        '../../dist/assets/navigation-profile.css',
        '../../dist/assets/content-section.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-interested">
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
            <a href="./interested.php" class="active">
                <?php echo file_get_contents("../../public/svg/heart.svg"); ?>
                <span>Interessados</span>
            </a>
            <a href="./orders.php">
                <?php echo file_get_contents("../../public/svg/order.svg"); ?>
                <span>Pedidos</span>
            </a>
            <a href="./donations.php">
                <?php echo file_get_contents("../../public/svg/donation.svg"); ?>
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
                        $interested = InterestedController::getAllByUserId($_SESSION['user_id']);
                        
                        if (count($interested) > 0) {
                            $eletronicPartsId = array_reduce($interested, function($array, Interested $item) {
                                $array[] = $item->getEletronicPartId();
                                return $array;
                            });
    
                            $eletronicParts = EletronicPartsController::getAllByIds($eletronicPartsId);
    
                            /** @var EletronicPart $eletronicPart */
                            foreach($eletronicParts as $eletronicPart) {
                                echo "
                                    <tr>
                                        <td 
                                            class=\"image\"><img src=\"../../storage/parts/{$eletronicPart->getImage()->name}\" 
                                            alt=\"Part Image\"
                                        ></td>
                                        <td class=\"name\">{$eletronicPart->getName()}</td>
                                        <td class=\"see-details\">
                                            <a href=\"./interested-details.php?eletronicPartId={$eletronicPart->getId()}\">
                                                <img src=\"../../public/svg/info.svg\" alt=\"\">
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