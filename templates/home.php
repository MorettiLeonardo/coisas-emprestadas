<?php
    include_once 'layouts/header.php';
    include_once '../app/produtos.php';
    include_once '../app/categorias.php';
?>
<div class="container">
    <div>
        <h1>Olá, <?php echo $_SESSION['usuarioLogado']['nome']; ?></h1>
        <hr/>
        <div>
            <a href="produtos.php?i=cad"><button class="button">Adicionar produto</button></a>
        </div>
        <div class="home">
            <div>
                <h4>Produtos emprestados</h4>
                <table class="table">
                    <thead>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php 
                            $dados = pegarProdutosEmprestados($_SESSION['usuarioLogado']['id']);
                            if(count($dados) > 0){
                                foreach($dados as $item):
                        ?>
                            <tr>
                                <td><?php echo $item["id"]; ?></td>
                                <td><?php echo $item["nome"]; ?></td>
                                <td><?php echo pegarCategoria($item["categoria"])["slug"]; ?></td>
                                <td>
                                    <a href="emprestimos.php?refund=<?php echo $item["id_emprestimo"]; ?>">
                                        <button class="button">Devolver</button>
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
            <div>
                <h4>Produtos disponíveis</h4>
                <table class="table">
                    <thead>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php 
                            $dados = pegarProdutosNaoEmprestados($_SESSION['usuarioLogado']['id']);
                            if(count($dados) > 0){
                                foreach($dados as $item):
                        ?>
                            <tr>
                                <td><?php echo $item["id"]; ?></td>
                                <td><?php echo $item["nome"]; ?></td>
                                <td><?php echo pegarCategoria($item["categoria"])["slug"]; ?></td>
                                <td>
                                    <a href="produtos.php?loan=<?php echo $item["id"]; ?>">
                                        <button class="button">Emprestar</button>
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
</div>    
<?php
    include_once 'layouts/footer.php';
?>