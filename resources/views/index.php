<?php
    $title = 'Ecotech';
    $css['locations'] = [
        '../../public/styles/home.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-home">
    <header>
        <img src="../../public/assets/logo-yellow.svg" alt="Echotech Logo">
    </header>

    <main>
        <div class="quote">
            <h1>Não descarte seu lixo eletrônico na natureza,</h1>
            <p><b>compartilhe</b> com quem precisa.</p>
        </div>
    
        <div class="buttons">
            <a href="#" class="sign-up">
                <span>Sign Up</span>
            </a>
    
            <a href="#" class="sign-in">
                <span>Sign In</span>
                <!-- <img src="../../public/assets/sign-in.svg" alt="Sign in Icon"> -->
                <?php echo file_get_contents("../../public/assets/sign-in.svg"); ?>
            </a>
        </div>
    </main>
</div>

<?php include('../layouts/footer.php'); ?>