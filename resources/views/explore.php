<?php declare(strict_types=1);
    require_once __DIR__ . '/../../vendor/autoload.php';

    use App\Controllers\EletronicPartsController;
    use App\Models\EletronicPart;
    use App\Php\Util;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Explorar';
    $css['paths'] = [
        '../../public/styles/page-explore.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/modal.css',
        '../../public/styles/skeleton.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-explore">
    <nav>
        <div class="left">
            <img class="logo" src="../../public/assets/logo.svg" alt="">

            <div class="tabs">
                <a class="active" href="#">Explore</a>
                <a href="./interested.php">Profile</a>
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

    <form class="search-bar animate-up-op">
        <input 
            name="search" 
            type="text" 
            placeholder="Pesquise por uma peça" 
            value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>"
        >
        <button type="submit">
            <img src="../../public/assets/search.svg" alt="">
        </button>
    </form>

    <h2>Resultados:</h2>

    <div class="cards animate-up-op">
        <?php
            if (!isset($_GET['search'])) {
                $eletronicParts = EletronicPartsController::getAll();
            } else {
                $eletronicParts = EletronicPartsController::getAllByName($_GET['search']);
            }
            
            $favoritedEletronicParts = Util::getFavoritedEletronicPartsId($_SESSION['user_id']);

            /** @var EletronicPart $eletronicPart */
            foreach ($eletronicParts as $eletronicPart) { 
                if ($eletronicPart->getStock() > 0) {
                    echo "
                        <div 
                            data-id=\"{$eletronicPart->getId()}\" 
                            class=\"part\"
                        >
                            <div class=\"image\">
                                <img src=\"../../storage/parts/{$eletronicPart->getImage()->name}\" alt=\"\">
                            </div>
                            <div class=\"name\">{$eletronicPart->getName()}</div>
                            <div class=\"description\">{$eletronicPart->getDescription()}</div>
                            <div class=\"user-name\">• Aluno: {$eletronicPart->getPersonIdName()}</div>
                            <div class=\"buttons\">
                                <button class=\"see-details\">Ver detalhes</button>
                                <button 
                                    class=\"favorite\"
                                    data-is-favorited=\"".(in_array($eletronicPart->getId(), $favoritedEletronicParts) ? 'true' : 'false')."\"
                                >
                                    ".
                                    file_get_contents("../../public/assets/heart.svg").
                                    file_get_contents("../../public/assets/heart-filled.svg").
                                    "
                                </button>
                            </div>
                        </div>
                    ";
                }
            }           
        ?>
    </div>
</div>

<div id="modal" class="hide">
    <div class="container animate-modal">
        <header>
            <h1>
                Detalhes da Peça
            </h1>
            <img class="close" src="../../public/assets/close.svg" alt="">            
        </header>

        <div class="content"></div>

        <template id="modal-skeleton-template">
            <div class="left">
                <section>
                    <div class="image skeleton">
                        <div></div>
                    </div>
                    <div class="name">
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
                    <div class="stock">
                        <span style="width: 100%">
                            <div class="skeleton skeleton-text skeleton-title"></div>
                        </span>
                        <div style="width: 100%" class="amount">
                            <div class="skeleton skeleton-text skeleton-title"></div>
                        </div>
                    </div>
                </section>

                <div class="button-wrapper">
                    <button class="favorite skeleton">
                    </button>
                </div>
            </div>
    
            <div class="right">
                <section>
                    <div class="field">
                        <div class="skeleton skeleton-text skeleton-title"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
    
                    <div class="field">
                        <div class="skeleton skeleton-text skeleton-title"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
                    
                    <div class="field">
                        <div class="skeleton skeleton-text skeleton-title"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
    
                    <div class="field">
                        <span style="width: 100%">
                            <div class="skeleton skeleton-text skeleton-title"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                        </span>
                        <br>
                        <span style="width: 100%">
                            <div class="skeleton skeleton-text skeleton-title"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                        </span>
                    </div>
                </section>
    
                <div class="button-wrapper">
                    <button class="order skeleton">
                            
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<script src="../../dist/assets/explore.js" type="module"></script>
<?php include('../layouts/footer.php'); ?>