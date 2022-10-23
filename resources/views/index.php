<?php declare(strict_types=1);
    $title = 'Ecotech';
    $css['paths'] = [
        '../../dist/assets/page-home.css',
        '../../dist/assets/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-home">
    <header>
        <img class="animate-up-op" src="../../public/svg/logo-yellow.svg" alt="Echotech Logo">
    </header>

    <main>
        <div class="quote animate-up-op">
            <h1>Não descarte seu lixo eletrônico na natureza,</h1>
            <p><b>compartilhe</b> com quem precisa.</p>
        </div>
    
        <div class="buttons animate-up-op">
            <a href="./sign-up.php" class="sign-up">
                <span>Sign Up</span>
            </a>
    
            <a href="./sign-in.php" class="sign-in">
                <span>Sign In</span>
                <!-- <img src="../../public/svg/sign-in.svg" alt="Sign in Icon"> -->
                <?php echo file_get_contents("../../public/svg/sign-in.svg"); ?>
            </a>
        </div>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>