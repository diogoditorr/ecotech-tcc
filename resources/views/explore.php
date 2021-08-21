<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Controllers\PecasEletronicasController;
    use Models\PecaEletronica;

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Explorar';
    $css['locations'] = [
        '../../public/styles/page-explore.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/modal.css',
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
                $pecasEletronicas = PecasEletronicasController::getAll();
            } else {
                $pecasEletronicas = PecasEletronicasController::getAllByName($_GET['search']);
            }

            /** @var PecaEletronica $pecaEletronica */
            foreach ($pecasEletronicas as $pecaEletronica) { 
                if ($pecaEletronica->getEstoque() > 0) {
                    echo "
                        <div class=\"part\">
                            <div class=\"image\">
                                <img src=\"../../storage/parts/{$pecaEletronica->getImagem()->name}\" alt=\"\">
                            </div>
                            <div class=\"name\">{$pecaEletronica->getNome()}</div>
                            <div class=\"description\">{$pecaEletronica->getSobre()}</div>
                            <div class=\"user-name\">• Aluno: {$pecaEletronica->getPessoaIdNome()}</div>
                            <div class=\"buttons\">
                                <button class=\"see-details\">Ver detalhes</button>
                                <button class=\"favorite\"><img src=\"../../public/assets/heart.svg\" alt=\"\"></button>
                            </div>
                        </div>
                    ";
                }
            }           
        ?>

        <div class="part">
            <div class="image">
                <img src="../../storage/parts/image_1.png" alt="">
            </div>
            <div class="name">Semicondutores e transístores</div>
            <div class="description">
                Os componentes eletrônicos são todos os elementos que compõem a estrutura de um 
                circuito elétrico, ou seja, fazem parte de todo circuito eletrônico ou elétrico 
                e estão sempre ligados entre si, formando um sequencial de funções, interligando 
                todos os componentes e fornecendo um trabalho conjunto onde um interfere no funcionamento 
                do outro.
            </div>
            <div class="user-name">• Aluno: Jefferson</div>
            <div class="buttons">
                <button class="see-details">Ver detalhes</button>
                <button class="favorite"><img src="../../public/assets/heart.svg" alt=""></button>
            </div>
        </div>

        <div class="part">
            <div class="image">
                <img src="../../storage/parts/image_4.png" alt="">
            </div>
            <div class="name">Semicondutores</div>
            <div class="description">
                Semicondutores são sólidos geralmente cristalinos de condutividade elétrica intermediária entre condutores e isolantes.
            </div>
            <div class="user-name">• Aluno: Paulo</div>
            <div class="buttons">
                <button class="see-details">Ver detalhes</button>
                <button class="favorite"><img src="../../public/assets/heart.svg" alt=""></button>
            </div>
        </div>

        <div class="part">
            <div class="image">
                <img src="../../storage/parts/image_3.png" alt="">
            </div>
            <div class="name">Semicondutor de Potência</div>
            <div class="description">
                As chaves semicondutoras de potência são os elementos mais importantes em circuitos de eletrônica de potência.
            </div>
            <div class="user-name">• Aluno: Luis Fernando</div>
            <div class="buttons">
                <button class="see-details">Ver detalhes</button>
                <button class="favorite"><img src="../../public/assets/heart.svg" alt=""></button>
            </div>
        </div>
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

        <div class="content">
            <div class="left">
                <section>
                    <div class="image">
                        <img src="../../storage/parts/image_1.png" alt="">
                    </div>
                    <div class="name">Semicondutores e transístores</div>
                    <div class="stock">
                        <span>Estoque:</span>
                        <div class="amount">3 unidades</div>
                    </div>
                </section>

                <div class="button-wrapper">
                    <button class="favorite">
                        <img src="../../public/assets/heart.svg" alt="">
                        <span>Tenho Interesse</span>
                    </button>
                </div>
            </div>
    
            <div class="right">
                <section>
                    <div class="field">
                        <h2>Tipo:</h2>
                        <p>Semicondutores e transítores</p>
                    </div>
    
                    <div class="field">
                        <h2>Modelo:</h2>
                        <p>ON Semiconductor - NCV303LSN15T1G / NA Transistor - 2N2222A</p>
                    </div>
                    
                    <div class="field">
                        <h2>Sobre:</h2>
                        <p>Os componentes eletrônicos são todos os elementos que compõem a estrutura de um circuito elétrico, ou seja, fazem parte de todo circuito eletrônico ou elétrico e estão sempre ligados entre si, formando um sequencial de funções, interligando todos os componentes e fornecendo um trabalho conjunto onde um interfere no funcionamento do outro.</p>
                    </div>
    
                    <div class="field">
                        <h2>Contato:</h2>
                        <p>
                            Avenida Rua Ilha Bela, 80 <br>
                            Petrolina - Pernambuco
                        </p>
                        <p>
                            Telefone:<br> 
                            (15) 99000-99<br>
                            (15) 99000-88
                        </p>
                    </div>
                </section>
    
                <div class="button-wrapper">
                    <button class="order">
                        <span>Fazer Pedido</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer src="../../public/scripts/explore.js" type="text/javascript"></script>

<?php include('../layouts/footer.php'); ?>