<?php
    if(isset($_GET["i"])){
        $isCadastrar = true;
    }else{
        $isCadastrar = false;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css"/>
    <title>Login</title>
</head>
    <body>
        <div class="container-login">
            <div id="formulario">
                <h2>Coisas emprestadas</h2>
                <form name="formLogin" method="POST" style="display:<?php echo $isCadastrar ? "none" : "inline"; ?>;">
                    <div>
                        <div>
                            <label for="usuario">Usuário</label>
                            <input type="text" name="usuario" id="usuario" placeholder="Informe o usuário">
                        </div>
                        <div>
                            <label for="usuario">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Informe a senha">
                        </div>    
                    </div>
                    <button type="submit" name="btnEntrar">Entrar</button>
                    <a href="?i=cad">
                        <button type="button">Cadastrar-se</button>
                    </a>    
                </form>
                <form name="formCadUsuario" method="POST" style="display:<?php echo $isCadastrar ? "inline" : "none"; ?>;" onsubmit="return validarForm(this)">
                    <div>
                        <div>
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Informe o nome" maxlength="255">
                        </div>
                        <div>
                            <label for="usuario">Usuário</label>
                            <input type="text" name="usuario" id="usuario" placeholder="Informe o usuário" maxlength="100">
                        </div>
                        <div>
                            <label for="usuario">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Informe a senha" maxlength="100">
                        </div>    
                        <div>
                            <label for="confirma">Confirma senha</label>
                            <input type="password" name="confirma" id="confirma" placeholder="Confirme a senha" maxlength="100">
                        </div>
                    </div>
                    <button type="submit" name="btnCadastrar">Cadastrar</button>
                    <a href="index.php">
                        <button type="button">Cancelar</button>
                    </a>
                </form>
                <p id="label_error" style="display:none;"></p>
                <?php
                    if(isset($_POST['btnEntrar'])){
                        include_once 'app/config.php';
                        include_once 'app/usuarios.php';

                        $usuario = login($_POST['usuario'], $_POST['senha']);

                        if(!empty($usuario)){
                            criarSessao($usuario);
                            header("location:templates/home.php");
                        }else{
                            echo "<p id='label_error'>Usuário ou senha inválidos!</p>";
                        }
                    } 
                    
                    if(isset($_POST['btnCadastrar'])){
                        include_once 'app/config.php';
                        include_once 'app/usuarios.php';
                        
                        $usuario = pegarUsuarioPorUsuario($_POST['usuario']);
                        if(empty($usuario)){
                            if(inserirUsuario($_POST['nome'], $_POST['usuario'], $_POST['senha'], '2')){
                                $usuario = login($_POST['usuario'], $_POST['senha']);
                                criarSessao($usuario);
                                header("location:templates/home.php");
                            }else{
                                echo "<p id='label_error'>Não foi possível criar o usuário</p>";
                            }
                        }else{
                            echo "<p id='label_error'>Usuário já existe!</p>";
                        }
                    }
                ?>
            </div>
        </div>
        <script src="static/js/utils.js"></script>    
    </body>
</html>

