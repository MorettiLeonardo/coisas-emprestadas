<?php 
    include_once 'conexao.php';
    include_once 'produtos.php';

    function pegarTodosEmprestimos($idUsuario){
        $array_emprestimos = array();
        $conexao = conectar();
        $idUsuario = $conexao->real_escape_string($idUsuario);
        $stmt = $conexao->query("SELECT id, id_produto, data_emprestimo, data_devolucao, nome_destinatario, email_destinatario, status  FROM emprestimos WHERE id_usuario = '$idUsuario'");
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_emprestimo = array(
                    "id" => $linha[0],
                    "produto" => $linha[1],
                    "data_emprestimo" => $linha[2],
                    "data_devolucao" => $linha[3],
                    "nome_destinatario" => $linha[4],
                    "email_destinatario" => $linha[5],
                    "status" => $linha[6]
                );

                array_push($array_emprestimos, $array_emprestimo);
            }
        }
        desconectar($conexao);
        return $array_emprestimos;
    }

    function pegarEmprestimo($id){
        $array_emprestimo = array();
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $stmt = $conexao->query("SELECT id, id_produto, data_emprestimo, data_devolucao, nome_destinatario, email_destinatario, status, id_usuario  FROM emprestimos WHERE id = '$id'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();
            $array_emprestimo = array(
                "id" => $linha[0],
                "produto" => $linha[1],
                "data_emprestimo" => $linha[2],
                "data_devolucao" => $linha[3],
                "nome_destinatario" => $linha[4],
                "email_destinatario" => $linha[5],
                "status" => $linha[6],
                "id_usuario" => $linha[7]
            );
        }
        desconectar($conexao);
        return $array_emprestimo;
    }

    function inserirEmprestimo($idProduto, $dataEmprestimo, $nomeDestinatario, $emailDestinatario, $idUsuario){
        $retorno = false;
        $conexao = conectar();
        $idProduto = $conexao->real_escape_string($idProduto);
        $dataEmprestimo = $conexao->real_escape_string($dataEmprestimo);
        $nomeDestinatario = $conexao->real_escape_string($nomeDestinatario);
        $emailDestinatario = $conexao->real_escape_string($emailDestinatario);
        $idUsuario = $conexao->real_escape_string($idUsuario);

        define("SQL_INSERT", "INSERT INTO emprestimos (id_produto, data_emprestimo, nome_destinatario, email_destinatario, id_usuario)VALUES(?, ?, ?, ?, ?)");
        $stmt = $conexao->prepare(constant("SQL_INSERT"));
        echo var_dump($stmt);
        $stmt->bind_param('isssi', $idProduto, $dataEmprestimo, $nomeDestinatario, $emailDestinatario, $idUsuario);
        $retorno = $stmt->execute();
        $retorno = emprestarProduto($idProduto);
        
        desconectar($conexao);
        return $retorno;
    }

    function atualizarEmprestimo($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $data_devolucao = date("Y-m-d");
        define("SQL_UPDATE", "UPDATE emprestimos SET status = 1, data_devolucao = ? WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE"));
        $stmt->bind_param('si', $data_devolucao, $id);
        $retorno = $stmt->execute();
        if($retorno){
            devolverProduto(pegarEmprestimo($id)["produto"]);
        }
        desconectar($conexao);
        return $retorno;
    }
?>
