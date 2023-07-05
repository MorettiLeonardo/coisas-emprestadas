<?php
    include_once 'layouts/header.php';
    include_once '../app/categorias.php';

    if(isset($_GET['edit'])){
        $categoria = pegarCategoria($_GET['edit']);
        if($categoria["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            $tituloModal = "Editar categoria";
            $displayModal = "flex";
        }else{
            header("location:categorias.php");
        }
    }else{
        $tituloModal = "Cadastrar categoria";
        $displayModal = "none";
    }

    if(isset($_POST['btnCadastrar'])){
        if(inserirCategoria($_POST['slug'], $_SESSION['usuarioLogado']['id'])){
            header("location:categorias.php");
        }else{
            echo "Ocorreu um erro categoria não adicionada!";
        }
    }

    if(isset($_POST['btnEditar'])){
        $id = $_GET['edit'];
        $categoria = pegarCategoria($_GET['edit']);
        if($categoria["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(editarCategoria($_POST['slug'], $id)){
                header("location:categorias.php");
            }else{
                echo "Ocorreu um erro categoria não alterado!";
            }
        }else{
            header("location:categorias.php");
        }
    }

    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $categoria = pegarCategoria($_GET['del']);
        if($categoria["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(excluirCategoria($id)){
                header("location:categorias.php");
            }else{
                echo "Ocorreu um erro categoria não excluído!";
            }
        }else{
            header("location:categorias.php");            
        }
    }
?>
<div class="container">
    <div>
        <div>
            <h1>Categorias produtos</h1>
        </div>
        <hr/>
        <div>
            <button class="button button-head" onclick="openModal()">Adicionar categoria</button>
            <table class="table">
                <thead>
                    <th>Código</th>
                    <th>Slug</th>
                </thead>
                <tbody>
                    <?php 
                        $dados = pegarTodasCategorias($_SESSION['usuarioLogado']['id']);
                        if(count($dados) > 0){
                            foreach($dados as $item):
                    ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo $item["slug"]; ?></td>
                            <td>
                                <a onclick="return confirmarExclusao()" href="categorias.php?del=<?php echo $item["id"]; ?>">
                                    <button class="button">Excluir</button>
                                </a>
                                <a href="categorias.php?edit=<?php echo $item["id"]; ?>">
                                    <button class="button">Editar</button>
                                </a>
                            </td>
                        </tr>
                    <?php 
                            endforeach;
                        }else{
                    ?>
                    <tr>
                        <td colspan="2">Nenhum registro encontrado!</td>
                    </tr>
                    <?php 
                        }
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
                $categoria = pegarCategoria($_GET['edit']);
            ?>
            <form name="formEditCategoria" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="slug">Nome</label>
                        <input type="text" name="slug" id="slug" placeholder="Informe o slug da categoria" maxlength="100" value="<?php echo $categoria["slug"]; ?>"/>
                    </div>
                </div>
                <button type="submit" name="btnEditar" class="button">Alterar</button>
                <a href="categorias.php">
                    <button type="button" class="button">Cancelar</button>
                </a>    
            </form>
            <?php 
                }else{
            ?>
            <form name="formCadCategoria" method="POST" onsubmit="return validarForm(this)">
                <div>
                    <div>
                        <label for="slug">Nome</label>
                        <input type="text" name="slug" id="slug" maxlength="100" placeholder="Informe o slug da categoria"/>
                    </div>
                </div>
                <button type="submit" name="btnCadastrar" class="button">Cadastrar</button>
                <a href="categorias.php">
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