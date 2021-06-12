<?php

class ConexaoDB 
{
    /*
        - Você deve copiar e colar o mesmo arquivo no mesmo diretório.
        - Tirar ".example" do nome do arquivo. Resultado: "ConexaoDB.php"
        - Mudar as configurações de acordo com seu ambiente


        ------------ Configurações: ---------------
        $serverName = Nome do servidor. Padrão: localhost
        $userName = Nome de usuário
        $password = Senha do banco de dados
        $dbName = Nome do banco de dados a conectar. Antes disso você precisa
        criar um schema/database manualmente no MySQL Workbench ou PHPMyAdmin.
        $port = Porta do banco de dados
        -------------------------------------------
    */
    private $serverName = "localhost";
    private $userName = "root";
    private $password = "usbw";
    private $dbName = "ecotech";
    private $port = "3306";

    public function conectar(): \mysqli
    {
        $conn = new \mysqli(
            $this->serverName,
            $this->userName,
            $this->password,
            $this->dbName,
            $this->port
        );

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        ConexaoDB::createDatabase($conn);

        return $conn;
    }

    public static function createDatabase(\mysqli $conn)
    {
        $conn->multi_query("
            CREATE TABLE IF NOT EXISTS `pessoa` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `cpf` VARCHAR(11) NOT NULL,
                `email` VARCHAR(320) NOT NULL,
                `nome` TEXT NOT NULL,
                `escola` TEXT NOT NULL,
                `num_telefone_1` VARCHAR(20) NOT NULL,
                `num_telefone_2` VARCHAR(20) NULL,
                
                PRIMARY KEY (`id`),
                UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
                UNIQUE INDEX `email_UNIQUE` (`email` ASC)
            );

            CREATE TABLE IF NOT EXISTS `endereco` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `pessoa_id` INT NOT NULL,
                `estado` TEXT NOT NULL,
                `cidade` TEXT NOT NULL,
                `bairro` TEXT NOT NULL,
                `cep` VARCHAR(15) NOT NULL,

                PRIMARY KEY (`id`),
                INDEX `fk_pessoa_id_idx` (`pessoa_id` ASC),
                UNIQUE INDEX `pessoa_id_UNIQUE` (`pessoa_id` ASC),

                CONSTRAINT `fk_endereco_pessoa_id`
                    FOREIGN KEY (`pessoa_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION
            );

            CREATE TABLE IF NOT EXISTS `perfil` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `pessoa_id` INT NOT NULL,
                `email` VARCHAR(320) NOT NULL,
                `cpf` VARCHAR(11) NOT NULL,
                `nome_usuario` VARCHAR(45) NOT NULL,
                `senha` TEXT NOT NULL,
                
                UNIQUE INDEX `email_UNIQUE` (`email` ASC),
                UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
                UNIQUE INDEX `nome_usuario_UNIQUE` (`nome_usuario` ASC),
                UNIQUE INDEX `pessoa_id_UNIQUE` (`pessoa_id` ASC),
                
                PRIMARY KEY (`id`),
                CONSTRAINT `fk_perfil_pessoa_email`
                    FOREIGN KEY (`email`)
                    REFERENCES `pessoa` (`email`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT `fk_perfil_pessoa_cpf`
                    FOREIGN KEY (`cpf`)
                    REFERENCES `pessoa` (`cpf`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT `fk_perfil_pessoa_id`
                    FOREIGN KEY (`pessoa_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION
            );

            CREATE TABLE IF NOT EXISTS `peca_eletronica` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `pessoa_id` INT NOT NULL,
                `nome` TEXT NOT NULL,
                `tipo` TEXT NOT NULL,
                `modelo` TEXT NOT NULL,
                `sobre` TEXT NOT NULL,
                `imagem` TEXT NOT NULL,
                `estoque` INT NULL DEFAULT 0,
                
                PRIMARY KEY (`id`),
                INDEX `fk_pessoa_id_idx` (`pessoa_id` ASC),

                CONSTRAINT `fk_peca_eletronica_pessoa_id`
                    FOREIGN KEY (`pessoa_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION
            );

            CREATE TABLE IF NOT EXISTS `interessados` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `pessoa_id` INT NOT NULL,
                `peca_eletronica_id` INT NOT NULL,

                PRIMARY KEY (`id`),
                INDEX `fk_pessoa_id_idx` (`pessoa_id` ASC),
                INDEX `fk_peca_eletronica_id_idx` (`peca_eletronica_id` ASC),

                CONSTRAINT `fk_interessados_pessoa_id`
                    FOREIGN KEY (`pessoa_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT `fk_interessados_peca_eletronica_id`
                    FOREIGN KEY (`peca_eletronica_id`)
                    REFERENCES `peca_eletronica` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION
            );

            CREATE TABLE IF NOT EXISTS `pedidos` (
                `id` VARCHAR(8) NOT NULL AUTO_INCREMENT,
                `peca_eletronica_id` INT NOT NULL,
                `doador_id` INT NOT NULL,
                `cliente_id` INT NOT NULL,
                `status` TEXT NOT NULL DEFAULT 'pendente',
                `created_at` TIMESTAMP NOT NULL,

                PRIMARY KEY (`id`),
                INDEX `fk_doador_id_idx` (`doador_id` ASC),
                INDEX `fk_cliente_id_idx` (`cliente_id` ASC),
                INDEX `fk_peca_eletronica_id_idx` (`peca_eletronica_id` ASC),

                CONSTRAINT `fk_pedidos_doador_id`
                    FOREIGN KEY (`doador_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT `fk_pedidos_cliente_id`
                    FOREIGN KEY (`cliente_id`)
                    REFERENCES `pessoa` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT `fk_pedidos_peca_eletronica_id`
                    FOREIGN KEY (`peca_eletronica_id`)
                    REFERENCES `peca_eletronica` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION
            );
        ");
    }
}