<?php
    include_once 'layouts/header.php';
    include_once '../app/usuarios.php';
    include_once '../app/tipo_usuario.php';
    
    if(intval($_SESSION["usuarioLogado"]["tipo_usuario"]) == 2){
        header("location:home.php");
    }

    if(isset($_GET['edit'])){
        $tituloModal = "Editar usuário";
        $displayModal = "flex";
    }else if(isset($_GET['pass'])){
        $tituloModal = "Alterar senha";
        $displayModal = "flex";
    }else{
        $tituloModal = "Cadastrar Usuário";
        $displayModal = "none";
    }

    if(isset($_POST['btnCadastrar'])){
        $usuario = pegarUsuarioPorUsuario($_POST['usuario']);
        if(empty($usuario)){
            if(inserirUsuario($_POST['nome'], $_POST['usuario'], $_POST['senha'], $_POST['tipoUsuario'])){
                header("location:usuarios.php");
            }else{
                echo "<div class='alert-error'>".
                     "<p>Ocorreu um erro usuário não adicionado!</p>" .
                     "</div>";
            }
        }else{
            echo "<div class='alert-error'>".
                 "<p>Usuário já existe!</p>" .
                 "</div>";
        }
    }

    if(isset($_POST['btnEditar'])){
        $id = $_GET['edit'];
        if(intval($_SESSION["usuarioLogado"]["tipo_usuario"]) == 1){
            if(editarUsuario($_POST['nome'], $_POST['usuario'], $_POST['tipoUsuario'], $id)){
                header("location:usuarios.php");
            }else{
                echo "<div class='alert-error'>".
                     "<p>Ocorreu um erro usuário não alterado!</p>" .
                     "</div>";
            }
        }else{
            header("location:home.php");
        }
    }
    
    if(isset($_POST['btnEditarSenha'])){
        $id = $_GET['pass'];
        if(intval($_SESSION["usuarioLogado"]["tipo_usuario"]) == 1){
            if(editarSenha($_POST['senha'], $id)){
                header("location:usuarios.php");
            }else{
                echo "<div class='alert-error'>".
                     "<p>Ocorreu um erro senha não alterada!</p>" .
                     "</div>";
            }
        }else{
            header("location:home.php");
        }   
    }

    if(isset($_GET['del'])){
        if(excluirUsuario($_GET['del'])){
            header("location:usuarios.php");
        }else{
            echo "<div class='alert-error'>".
                 "<p>Ocorreu um erro senha não alterada!</p>" .
                 "</div>";
        }
    }
    
?>
<div class="container">
    <div>
        <div>
            <h1>Usuários</h1>
            <hr/>
        </div>
        <div>
            <button class="button button-head" onclick="openModal()">Adicionar usuário</button>
            <table class="table">
                <thead>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Tipo usuário</th>
                </thead>
                <tbody>
                    <?php
                        foreach(pegarTodosUsuarios() as $item):
                    ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo $item["nome"]; ?></td>
                            <td><?php echo $item["usuario"]; ?></td>
                            <td><?php echo pegarSlugTipoUsuario($item["tipo_usuario"]); ?></td>
                            <td>
                                <a onclick="return confirmarExclusao()" href="usuarios.php?del=<?php echo $item["id"]; ?>">
                                    <button class="button">Excluir</button>
                                </a>
                                <a href="usuarios.php?edit=<?php echo $item["id"]; ?>">
                                    <button class="button">Editar</button>
                                </a>
                                <a href="usuarios.php?pass=<?php echo $item["id"]; ?>">
                                    <button class="button">Alterar senha</button>
                                </a>
                            </td>
                        </tr>
                    <?php 
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>    
</div>
<div class="modal" style="display:<?php echo $displayModal; ?>">
    <div class="container-modal">
        <div id="head">
            <h2>
                <?php
                    echo $tituloModal;
                ?>
            </h2>
        </div>
        <div id="body">
            <?php 
                if(isset($_GET['edit'])){
                    $usuario = pegarUsuario($_GET['edit']);
            ?>
            <form name="formEditUsuario" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Informe o nome" value="<?php echo $usuario["nome"]; ?>"/>
                    </div>    
                    <div>
                        <label for="usuario">Usuário</label>
                        <input type="text" name="usuario" id="usuario" placeholder="Informe o usuário" value="<?php echo $usuario["usuario"]; ?>"/>
                    </div>
                    <div>
                        <label for="tipoUsuario">Tipo usuário</label>
                        <select name="tipoUsuario" id="tipoUsuario">
                            <option value="1" <?php echo intval($usuario["tipo_usuario"]) == 1 ? "selected" : ""; ?>>Administrador</option>
                            <option value="2" <?php echo intval($usuario["tipo_usuario"]) == 2 ? "selected" : ""; ?>>Comum</option>
                        </select>
                    </div>    
                </div>    
                <button type="submit" name="btnEditar" class="button">Alterar</button>
                <a href="usuarios.php">
                    <button type="button" class="button">Cancelar</button>
                </a>
            </form>    
            <?php 
                }elseif(isset($_GET['pass'])){
                    $usuario = pegarUsuario($_GET['pass']);
            ?>
            <form name="formEditSenha" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="nome">Código</label>
                        <input type="number" name="id" id="id" value="<?php echo $usuario["id"]; ?>" disabled="true"/>
                    </div>
                    <div>    
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Informe o nome" value="<?php echo $usuario["nome"]; ?>" disabled="true"/>
                    </div>
                    <div>
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Informe a senha"/>
                    </div>
                    <div>    
                        <label for="confirma">Confirma senha</label>
                        <input type="password" name="confirma" id="confirma" placeholder="Confirme a senha"/>
                    </div>    
                </div>    
                <button type="submit" name="btnEditarSenha" class="button">Alterar</button>
                <a href="usuarios.php">
                    <button type="button" class="button">Cancelar</button>
                </a>
            </form> 
            <?php 
                }else{
            ?>
            <form name="formCadUsuario" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Informe o nome"/>
                    </div>
                    <div>    
                        <label for="usuario">Usuário</label>
                        <input type="text" name="usuario" id="usuario" placeholder="Informe o usuário"/>
                    </div>
                    <div>    
                        <label for="tipoUsuario">Tipo usuário</label>
                        <select name="tipoUsuario" id="tipoUsuario">
                            <option value="1">Administrador</option>
                            <option value="2">Comum</option>
                        </select>
                    </div>
                    <div>    
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Informe a senha"/>
                    </div>    
                    <div>    
                        <label for="confirma">Confirma senha</label>
                        <input type="password" name="confirma" id="confirma" placeholder="Confirme a senha"/>
                    </div>   
                </div>    
                <button type="submit" name="btnCadastrar" class="button">Cadastrar</button>
                <a href="usuarios.php">
                    <button type="button" class="button">Cancelar</button>
                </a>
            </form>
            <?php 
                }
            ?>
            <p id="label_error" style="display:none;"></p>
        </div>
    </div>
</div>
<?php
    include_once 'layouts/footer.php';
?>