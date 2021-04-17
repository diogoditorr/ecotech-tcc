<?php
    $title = 'Ecotech | Explorar';
    $css['locations'] = [
        '../../public/styles/page-explore.css',
        '../../public/styles/navegation-bar.css',
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
                <div class="name">Diego</div>
                <img class="dropdown" src="../../public/assets/dropdown.svg" alt="dropdown">
            </div>
        </div>
    </nav>

    <div class="search-bar">
        <input type="text" placeholder="Pesquise por uma peça">
        <button>
            <img src="../../public/assets/search.svg" alt="">
        </button>
    </div>

    <h2>Resultados:</h2>

    <div class="cards">
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
                <img src="../../storage/parts/image_1.png" alt="">
            </div>
            <div class="name">Semicondutores e transístores</div>
            <div class="description">
                Os componentes eletrônicos são todos os elementos que compõem a estrutura de um 
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
    </div>
</div>

<div id="modal" class="hide">
    <div class="container">
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