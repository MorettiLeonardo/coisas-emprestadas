<?php
    include_once 'layouts/header.php';
    include_once '../app/produtos.php';
    include_once '../app/categorias.php';
    include_once '../app/emprestimos.php';
    
    if(isset($_GET['edit'])){
        $produto = pegarProduto($_GET['edit']);
        if($produto["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            $tituloModal = "Editar produto";
            $displayModal = "flex";
        }else{
            header("location:produtos.php");
        }
        
    }else if(isset($_GET['loan'])){
        $produto = pegarProduto($_GET['loan']);
        if($produto["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            $tituloModal = "Emprestar produto";
            $displayModal = "flex";
        }else{
            header("location:produtos.php");
        }
    }else if(isset($_GET['i'])){
        if($_GET['i'] == 'cad'){
            $tituloModal = "Cadastrar produto";
            $displayModal = "flex";
        }
    }else{
        $tituloModal = "Cadastrar produto";
        $displayModal = "none";
    }

    if(isset($_POST["btnCadastrar"])){
        if(inserirProduto($_POST['nome'], $_POST['categoria'], $_SESSION['usuarioLogado']['id'])){
            header("location:produtos.php");
        }else{
            echo "Ocorreu um erro produto não adicionada!";
        }
    }

    if(isset($_POST["btnEditar"])){
        $id = $_GET['edit'];
        $produto = pegarProduto($_GET['edit']);
        if($produto["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(!isProdutoEmprestado($id)){
                if(editarProduto($_POST['nome'], $_POST['categoria'], $id)){
                    header("location:produtos.php");
                }else{
                    echo "Ocorreu um erro produto não adicionada!";
                }
            }else{
                $displayModal = "none";
                echo "<div class='alert-error'>".
                     "<p>" .
                     "Alteração não permitida!<br/>" .
                     "Produto já emprestado." .
                     "</p>" .
                     "</div>";
            }
        }else{
            header("location:produtos.php");          
        }
    }

    if(isset($_POST["btnEmprestar"])){
        $idProduto = $_GET['loan'];
        $produto = pegarProduto($_GET['loan']);
        if($produto["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(inserirEmprestimo($idProduto, $_POST['dataEmprestimo'],$_POST['nomeDestinatario'],$_POST['emailDestinatario'],$_SESSION['usuarioLogado']['id'])){
                header("location:produtos.php");
            }else{
                echo "Ocorreu um erro produto não emprestado!";
            }
        }else{
            header("location:produtos.php");          
        }
    }
    
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $produto = pegarProduto($_GET['del']);
        if($produto["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(!isProdutoEmprestado($id)){
                if(excluirProduto($id)){
                    header("location:produtos.php");
                }else{
                    echo "Ocorreu um erro categoria não excluído!";
                }
            }else{
                $displayModal = "none";
                echo "<div class='alert-error'>".
                     "<p>" .
                     "Exclusão não permitida!<br/>" .
                     "Produto já emprestado." .
                     "</p>" .
                     "</div>";
            }    
        }else{
            header("location:produtos.php");          
        }
    }
?>
<div class="container">
    <div>
        <div>
            <h1>Produtos</h1>
        </div>
        <hr/>
        <div>
            <button class="button button-head" onclick="openModal()">Adicionar produto</button>
            <table class="table">
                <thead>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <?php 
                        $dados = pegarTodosProdutos($_SESSION['usuarioLogado']['id']);
                        if(count($dados) > 0){
                            foreach($dados as $item):
                    ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo $item["nome"]; ?></td>
                            <td><?php echo pegarCategoria($item["categoria"])["slug"]; ?></td>
                            <td>
                                <?php 
                                    if(intval($item["is_emprestado"]) == 1){
                                        echo "Emprestado";
                                    }else{
                                ?>
                                    <a href="produtos.php?loan=<?php echo $item["id"]; ?>">
                                        <button class="button">Emprestar</button>
                                    </a>
                                <?php 
                                    }
                                ?>
                                <a onclick="return confirmarExclusao()" href="produtos.php?del=<?php echo $item["id"]; ?>">
                                    <button class="button">Excluir</button>
                                </a>
                                <a href="produtos.php?edit=<?php echo $item["id"]; ?>">
                                    <button class="button">Editar</button>
                                </a>
                            </td>
                        </tr>
                    <?php 
                            endforeach;
                        }else{
                    ?>
                        <tr>
                            <td colspan="4">Nenhum registro encontrado!</td>
                        </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>    
</div>
<div class="modal" style="display:<?php echo $displayModal; ?>;">
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
                $produto = pegarProduto($_GET['edit']);
            ?>
            <form name="formEditProduto" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Informe o nome" maxlength="255"  value="<?php echo $produto["nome"]; ?>">
                    </div>
                    <div>    
                        <label for="categoria" id="categoria">Categoria</label>
                        <select name="categoria">
                            <?php
                                foreach(pegarTodasCategorias($_SESSION['usuarioLogado']['id']) as $item):
                            ?>
                            <option value="<?php echo $item["id"]; ?>"<?php echo $item["id"] == $produto["categoria"] ? ' selected ' : ''; ?>><?php echo $item["slug"]; ?></option>
                            <?php 
                                endforeach;
                            ?>
                        </select>
                    </div>    
                </div>    
                <button type="submit" name="btnEditar" class="button">Alterar</button>
                <a href="produtos.php">
                    <button type="button" class="button">Cancelar</button>
                </a>
            </form>
            <?php 
                }else if(isset($_GET['loan'])){
                    $produto = pegarProduto($_GET['loan']);
            ?>
            <form name="formEmprestimoCad" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="produto">Produto</label>
                        <input type="text" value="<?php echo $produto["nome"]; ?>" disabled="true"/>
                    </div>    
                    <div>
                        <label for="produto">Categoria</label>
                        <input type="text" value="<?php echo pegarCategoria($produto["categoria"])["slug"]; ?>" disabled="true"/>
                    </div>    
                    <div>    
                        <label for="produto">Data empréstimo</label>
                        <input type="date" name="dataEmprestimo" id="dataEmprestimo"/>
                    </div>    
                    <div>
                        <label for="nome">Nome Destinatário</label>
                        <input type="text" name="nomeDestinatario" id="nomeDestinatario" maxlength="255" placeholder="Informe o nome do destinatário"/>
                    </div>    
                    <div>
                        <label for="nome">E-mail Destinatário</label>
                        <input type="email" name="emailDestinatario" id="emailDestinatario" maxlength="255" placeholder="Informe o e-mail do destinatário"/>
                    </div>    
                </div>    
                <button type="submit" name="btnEmprestar" class="button">Emprestar</button>
                <a href="produtos.php">
                    <button type="button" class="button">Cancelar</button>
                </a>
            </form>
            <?php 
                }else{
            ?>
            <form name="formCadProduto" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" maxlength="255" placeholder="Informe o nome"/>
                    </div>    
                    <div>
                        <label for="categoria" id="categoria">Categoria</label>
                        <select name="categoria">
                            <?php
                                foreach(pegarTodasCategorias($_SESSION['usuarioLogado']['id']) as $item):
                            ?>
                            <option value="<?php echo $item["id"]; ?>"><?php echo $item["slug"]; ?></option>
                            <?php 
                                endforeach;
                            ?>
                        </select>
                    </div>    
                </div>    
                <button type="submit" name="btnCadastrar" class="button">Cadastrar</button>
                <a href="produtos.php">
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