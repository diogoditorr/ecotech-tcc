<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in.php');
    }

    $title = 'Ecotech | Bate papo';
    $css['paths'] = [
        '../../public/styles/page-chat.css',
        '../../public/styles/navigation-bar.css',
        '../../public/styles/navigation-profile.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-chat">
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
            <a href="./donations.php">
                <?php echo file_get_contents("../../public/assets/donation.svg"); ?>
                <span>Doações</span>
            </a>
            <a href="#" class="active">
                <?php echo file_get_contents("../../public/assets/chat.svg"); ?>
                <span>Bate Papo</span>
            </a>
        </section>

        <section class="content">
            <div class="chat-area">
                <header>
                    <div class="details">
                        <div class="to-user_name">Luis Fernando</div>
                        <div class="order-id">#P9ACN678</div>
                    </div>
                    <a href="./orders.php" class="back-icon">
                        <?php echo file_get_contents("../../public/assets/arrow-left-small.svg"); ?>
                    </a>
                </header>

                <!-- 
                    outgoing = from you
                    incoming = to you
                    -->

                <div class="chat-box scroll">
                    <div class="message outgoing">
                        <div class="content">
                            <p>Que bom que está interessado!</p>
                        </div>
                    </div>
                    <div class="message incoming">
                        <div class="content">
                            <p>Obrigado!</p>
                        </div>
                    </div>
                    <div class="message incoming">
                        <div class="content">
                            <p>Como podemos se encontrar?</p>
                        </div>
                    </div>
                    <div class="message outgoing">
                        <div class="content">
                            <p>Vou estar livre no dia 26 às 18:00 no centro. Tudo bem pra você?</p>
                        </div>
                    </div>
                    <div class="message incoming">
                        <div class="content">
                            <p>Claro!</p>
                        </div>
                    </div>
                    <div class="message outgoing">
                        <div class="content">
                            <p>Marcado então 😀</p>
                        </div>
                    </div>
                </div>

                <form action="#" class="typing-area">
                    <!-- <input type="text" name="outgoing_user_id" value="<?= $_SESSION['user_id'] ?>" hidden>
                    <input type="text" name="incoming_user_id" value="<?= $user_id ?>" hidden> -->

                    <input type="text" name="message" class="input-field" placeholder="Digite uma mensagem">
                    <button>
                        <?php echo file_get_contents("../../public/assets/send-message.svg"); ?>
                    </button>
                </form>
            </div>
        </section>
    </main>
</div>

<script src="../../dist/assets/chat.js" type="module"></script>

<?php include('../layouts/footer.php'); ?>


