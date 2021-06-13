<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Detalhes da peça';
    $css['locations'] = [
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
                <div class="name">Diego</div>
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
                        <img src="../../storage/parts/image_1.png" alt="">
                    </div>

                    <div class="menu">
                        <div class="name">
                            Semicondutores e transístores
                        </div>
                        
                        <div class="stock">
                            <span>Estoque:</span>
                            <div class="amount">3 unidades</div>
                        </div>

                        <div class="buttons">
                            <button class="remove-favorite">
                                <?php echo file_get_contents("../../public/assets/heart.svg"); ?>
                                <span>Remover</span>
                            </button>
                            <button class="order">
                                <span>Fazer Pedido</span>
                            </button>
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
                            <td>Jefferson Carvalho de Almeida</td>
                        </tr>
                        <tr>
                            <td>Endereço</td>
                            <td>Avenida Rua Ilha Bela, 80, Petrolina - Pernambuco</td>
                        </tr>
                        <tr>
                            <td>Telefone</td>
                            <td>
                                (15) 99000-99 <br>
                                (15) 3380-3099
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
                            <td>Semicondutores e transítores</td>
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td>
                                ON Semiconductor - NCV303LSN15T1G / NA Transistor - 2N2222A
                            </td>
                        </tr>
                        <tr>
                            <td>Sobre</td>
                            <td>
                                Os componentes eletrônicos são todos os elementos que 
                                compõem a estrutura de um circuito elétrico, ou seja, 
                                fazem parte de todo circuito eletrônico ou elétrico e 
                                estão sempre ligados entre si, formando um sequencial 
                                de funções, interligando todos os componentes e 
                                fornecendo um trabalho conjunto onde um interfere no 
                                funcionamento do outro.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
    

</div>


<?php include('../layouts/footer.php'); ?>