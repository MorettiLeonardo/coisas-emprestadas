<?php
    include_once 'layouts/header.php';
    include_once '../app/produtos.php';
    include_once '../app/emprestimos.php';

    if(isset($_GET['refund'])){
        $id = $_GET['refund'];
        $emprestimo = pegarEmprestimo($id);
        if($emprestimo["id_usuario"] == $_SESSION["usuarioLogado"]["id"]){
            if(atualizarEmprestimo($id)){
                header("location:emprestimos.php");
            }else{
                echo "Ocorreu um erro produto não devolvido!";
            }
        }else{
            header("location:emprestimos.php");
        }
    }
?>
<div class="container">
    <div>
        <div>
            <h1>Empréstimos</h1>
        </div>
        <hr/>
        <div>
            <table class="table">
                <thead>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Data empréstimo</th>
                    <th>Data devolução</th>
                    <th>Nome destinatário</th>
                    <th>E-mail destinatário</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php 
                        $dados = pegarTodosEmprestimos($_SESSION['usuarioLogado']['id']);
                        if(count($dados) > 0){
                            foreach($dados as $item):
                    ?>
                        <tr>
                            <td><?php echo $item["id"]; ?></td>
                            <td><?php echo pegarProduto($item["produto"])["nome"]; ?></td>
                            <td><?php echo date_format(date_create($item["data_emprestimo"]), "d/m/Y"); ?></td>
                            <td>
                                <?php 
                                    if(empty($item["data_devolucao"])){
                                        echo "Não definido";
                                    }else{
                                        echo date_format(date_create($item["data_devolucao"]), "d/m/Y");
                                    } 
                                ?>
                            </td>
                            <td><?php echo $item["nome_destinatario"]; ?></td>
                            <td><?php echo $item["email_destinatario"]; ?></td>
                            <td>
                                <?php 
                                    if(intval($item["status"]) == 1){
                                        echo "Devolvido";
                                    }else{
                                ?>
                                    <a href="emprestimos.php?refund=<?php echo $item["id"]; ?>" onclick="return confirm('Confirma a devolução do produto?')">
                                        <button class="button">Devolver</button>
                                    </a>
                                <?php 
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php
                            endforeach;
                        }else{
                    ?>
                        <tr>
                            <td colspan="7">Nenhum registro encontrado!</td>
                        </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>    
    </div>    
</div>
<?php
    include_once 'layouts/footer.php';
?>