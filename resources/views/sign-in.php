<?php declare(strict_types=1);
    $title = 'Ecotech | Login';
    $css['paths'] = [
        '../../dist/assets/page-sign-in.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-sign-in">
    <header>
        <a href="./index.php">
            <img src="../../public/svg/arrow-left-large.svg" alt="Voltar">
        </a>
        <img src="../../public/svg/logo-yellow.svg" alt="">
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
                            <?php echo file_get_contents("../../public/svg/email.svg"); ?>
                        </div>
                        <input type="text" name="emailCpf" id="emailCpf" required>
                    </div>
                </div>
                
                <div class="field">
                    <label for="password">Senha</label>
                    <div class="input">
                        <div class="svg">
                            <?php echo file_get_contents("../../public/svg/padlock.svg"); ?>
                        </div>
                        <input type="password" name="password" id="password" required>
                    </div>
                </div>

                <button type="submit">
                    <span>Sign In</span>
                    <?php echo file_get_contents("../../public/svg/sign-up.svg"); ?>
                </button>
            </fieldset>
        </form>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>