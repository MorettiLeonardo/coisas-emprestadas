<?php
    include_once '../app/config.php';
    if(!verificaSessao()){
        header("location:../");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/style.css"/>
    <title>Painel</title>
</head>
    <body>
        <nav>
            <h2>Coisas emprestadas</h2>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="emprestimos.php">Empréstimos</a></li>
                <?php
                    $usuario = $_SESSION['usuarioLogado'];
                    if($usuario["tipo_usuario"] == 1){
                ?>
                <li><a href="usuarios.php">Usuários</a></li>
                <?php 
                    }else{
                ?>
                <li><a href="perfil.php">Perfil</a></li>
                <?php 
                    }
                ?>
                <li><a href="../app/logout.php" onclick="return confirm('Deseja realmente sair?')">Sair</a></li>
            </ul>
        </nav>
