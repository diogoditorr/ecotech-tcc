<?php declare(strict_types=1);
    require_once __DIR__ . "/../../vendor/autoload.php";

    use App\Controllers\InterestedController;
    use App\Controllers\EletronicPartsController;
    use App\Controllers\PeopleController;
    use App\Models\EletronicPart;
    use App\Php\Util;
    
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
        exit();
    }
    
    $eletronicPart = EletronicPartsController::getById((int) $_GET['eletronicPartId']);
    if (!isset($eletronicPart)) {
        http_response_code(404);
        exit();
    }
    
    $person = PeopleController::getById($eletronicPart->getPersonId());
    
    if (!InterestedController::isEletronicPartFavorited(
        $eletronicPart->getId(),
        $_SESSION['user_id']
        )) {
            http_response_code(403);
            exit();
        }

    $title = 'Ecotech | Detalhes da peça';
    $css['paths'] = [
        '../../public/styles/page-interested-details.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-interested-details">
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

                <a href="./interested.php">
                    <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                </a>
            </header>

            <div class="container">
                <div class="wrapper">
                    <div class="image">
                        <img src="../../storage/parts/<?=$eletronicPart->getImage()->name?>" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            <?=$eletronicPart->getName()?>
                        </div>

                        <div class="stock">
                            <span>Estoque:</span>
                            <div class="amount"><?=$eletronicPart->getStock()?> unidades</div>
                        </div>

                        <div class="buttons">
                            <?php
                                $eletronicParts = Util::getFavoritedEletronicPartsId($_SESSION['user_id']);
                                
                                echo "
                                    <button 
                                        class=\"favorite\"
                                        data-is-favorited=\"".(in_array($eletronicPart->getId(), $eletronicParts) ? 'true' : 'false')."\"
                                    >
                                        ".
                                        file_get_contents("../../public/assets/heart.svg").
                                        file_get_contents("../../public/assets/heart-filled.svg")
                                        ."
                                        <span></span>
                                    </button>
                                ";
                            ?>
                            
                            <form action="../../src/php/request-order.php" method="post">
                                <input type="hidden" name="eletronicPartId" value="<?=$eletronicPart->getId()?>">
                                <input type="hidden" name="donorId" value="<?=$eletronicPart->getPersonId()?>">
                                <button class="order">
                                    <span>Fazer Pedido</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Contato</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nome</td>
                            <td><?=$person->getName()?></td>
                        </tr>
                        <tr>
                            <td>Endereço</td>
                            <td>
                                <?=$person->getAddress()->getAddress()?>,
                                <?=$person->getAddress()->getDistrict()?>, 
                                <?=$person->getAddress()->getCity()?> - 
                                <?=$person->getAddress()->getState()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Telefone</td>
                            <td>
                                <?=$person->getPhoneNumber1()?> <br>
                                <?=$person->getPhoneNumber2()?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>Detalhes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tipo</td>
                            <td><?=$eletronicPart->getType()?></td>
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td>
                                <?=$eletronicPart->getModel()?>
                            </td>
                        </tr>
                        <tr>
                            <td>Sobre</td>
                            <td>
                                <?=$eletronicPart->getDescription()?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
</div>

<script src="../../dist/assets/interested-details.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>