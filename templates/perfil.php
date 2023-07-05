<?php
    include_once 'layouts/header.php';
    include_once '../app/usuarios.php';
    include_once '../app/tipo_usuario.php';  
    $usuario = $_SESSION['usuarioLogado'];

    if(intval($usuario["tipo_usuario"]) == 1){
        header("location:home.php");
    }

    if(isset($_POST['btnEditar'])){
        if(editarUsuario($_POST['nome'], $_POST['usuario'], $usuario["tipo_usuario"], $usuario["id"])){
            atualizarSessao(pegarUsuario($usuario["id"]));
            header("location:perfil.php");
        }else{
            echo "Ocorreu um erro usuário não alterado!";
        }
    }
    
    if(isset($_POST['btnEditarSenha'])){
        if(editarSenha($_POST['senha'], $usuario["id"])){
            header("location:perfil.php");
        }else{
            echo "Ocorreu um erro senha não alterada!";
        }   
    }
?>
<div class="container">
    <div>
        <div>
            <h1>Perfil</h1>
            <hr/>
        </div>
        <div class="perfil">
            <div>
                <h4>Dados pessoais</h4>
                <form name="formEditPerfil" method="POST">
                    <div>
                        <div>
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Informe o nome" value="<?php echo $usuario["nome"]; ?>">
                        </div>
                        <div>
                            <label for="usuario">Usuário</label>
                            <input type="text" name="usuario" id="nome" placeholder="Informe o usuario" value="<?php echo $usuario["usuario"]; ?>">
                        </div>
                    </div>
                    <button name="btnEditar" class="button">Alterar</button>
                </form>
            </div>
            <div>
                <h4>Alterar senha</h4>
                <form name="formEditPass" method="POST">
                    <div>
                        <div>
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Informe a senha">
                        </div>
                        <div>
                            <label for="usuario">Confirme a senha</label>
                            <input type="password" name="confirma" id="confirma" placeholder="Confirme a senha">
                        </div>
                    </div>
                    <button name="btnEditarSenha" class="button">Alterar senha</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    include_once 'layouts/footer.php';
?>
