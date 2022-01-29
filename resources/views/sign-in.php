<?php
    $title = 'Ecotech | Login';
    $css['paths'] = [
        '../../public/styles/page-sign-in.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-sign-in">
    <header>
        <a href="./index.php">
            <img src="../../public/assets/arrow-left-large.svg" alt="Voltar">
        </a>
        <img src="../../public/assets/logo-yellow.svg" alt="">
    </header>

    <main>
        <form action="../../src/php/sign-in.php" method="post" class="animate-up-op" >
            <div class="header">
                <h1>Sign In</h1>
            </div>

            <fieldset>
                <div class="field">
                    <label for="emailCpf">E-mail / CPF</label>
                    <div class="input">
                        <div class="svg">
                            <?php echo file_get_contents("../../public/assets/email.svg"); ?>
                        </div>
                        <input type="text" name="emailCpf" id="emailCpf" required>
                    </div>
                </div>
                
                <div class="field">
                    <label for="password">Senha</label>
                    <div class="input">
                        <div class="svg">
                            <?php echo file_get_contents("../../public/assets/padlock.svg"); ?>
                        </div>
                        <input type="password" name="password" id="password" required>
                    </div>
                </div>

                <button type="submit">
                    <span>Sign In</span>
                    <?php echo file_get_contents("../../public/assets/sign-up.svg"); ?>
                </button>
            </fieldset>
        </form>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>