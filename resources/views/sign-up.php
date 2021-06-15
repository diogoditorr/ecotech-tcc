<?php
    $title = 'Ecotech | Cadastro de Usuário';
    $css['locations'] = [
        '../../public/styles/page-sign-up.css',
        '../../public/styles/animations.css',
    ];

    include('../layouts/header.php');
?>

<div id="page-sign-up">
    <header>
        <a href="./index.php">
            <img src="../../public/assets/arrow-left-large.svg" alt="Voltar">
        </a>
        <img src="../../public/assets/logo-yellow.svg" alt="">
    </header>

    <main>
        <form action="../../src/php/sign-up.php" method="post" class="animate-up-op">
            <div class="form-data">
                <div class="header">
                    <h1>Cadastro</h1>
                </div>

                <fieldset>
                    <legend>Perfil</legend>
    
                    <div class="field">
                        <label for="username">Nome de usuário</label>
                        <input type="text" name="username" id="username" maxlength="45" required>
                    </div>
                    <div class="field">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" maxlength="320" required>
                    </div>
                    <div class="field-half">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="field-half">
                        <label for="passwordConfirm">Confirmar senha</label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" required>
                    </div>
                </fieldset>
    
                <fieldset>
                    <legend>Dados</legend>
    
                    <div class="field">
                        <label for="fullName">Nome completo</label>
                        <input type="text" name="fullName" id="fullName" required>
                    </div>
                    <div class="field">
                        <label for="school">Escola</label>
                        <input type="text" name="school" id="school" required>
                    </div>
                    <div class="field-group">
                        <div class="field">
                            <label for="phoneNumber1">Número de telefone - 1</label>
                            <input 
                                type="tel" 
                                name="phoneNumber1" 
                                id="phoneNumber1" 
                                maxlength="20"
                                required
                            >
                        </div>
                        <div class="field">
                            <label for="phoneNumber2">Número de telefone - 2</label>
                            <input 
                                type="tel" 
                                name="phoneNumber2" 
                                id="phoneNumber2" 
                                maxlength="20"
                                required
                            >
                        </div>
                    </div>
                    <div class="field-half">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" maxlength="11" required>
                    </div>
                </fieldset>
    
                <fieldset>
                    <legend>Localização</legend>
    
                    <div class="field-group">
                        <div class="field">
                            <label for="state">Estado</label>
                            <select name="uf" id="state" required="required">
                                <option value="">Selecione o Estado</option>
                            </select>
    
                            <input type="hidden" name="state">
                        </div>
                        
                        <div class="field">
                            <label for="city">Cidade</label>
                            <select name="city" disabled required>
                                <option value="">Selecione a Cidade</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="field">
                        <label for="address">Endereço</label>
                        <input type="text" name="address" id="address" required>
                    </div>
    
                    <div class="field">
                        <label for="district">Bairro</label>
                        <input type="text" name="district" id="district" required>
                    </div>
    
                    <div class="field-half">
                        <label for="cep">CEP</label>
                        <input type="text" name="cep" id="cep" required>
                    </div>
                </fieldset>
            </div>

            <div class="footer">
                <div class="warning">
                    <img src="../../public/assets/warning.svg" alt="Warning Icon">
                    <span>Preencha todos os dados!</span>
                </div>

                <button type="submit">
                    <span>Sign Up</span>
                    <?php echo file_get_contents("../../public/assets/sign-up.svg"); ?>
                </button>
            </div>
        </form>
    </main>
</div>

<script src="../../public/scripts/sign-up.js"></script>

<?php include('../layouts/footer.php'); ?>