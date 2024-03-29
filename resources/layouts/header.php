<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Logo -->
    <link rel="shortcut icon" href="../../public/svg/logo-icon.svg" type="image/svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../../dist/assets/main.css">
    <?php 
        /** @var array $css 
         *  @var string $path
        */
        foreach($css["paths"] as $path) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$path\">";
        }
    ?>

    <!-- Scripts -->

    <title><?= $title ?? 'Document' ?></title>
</head>
<body>