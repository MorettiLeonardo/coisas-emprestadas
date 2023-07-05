<?php
    include_once 'conexao.php';

    function pegarTodosProdutos($idUsuario){
        $array_produtos = array();
        $conexao = conectar();
        $idUsuario = $conexao->real_escape_string($idUsuario);
        $stmt =  $conexao->query("SELECT id, nome, id_categoria, is_emprestado FROM produtos WHERE id_usuario = '$idUsuario'");
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_produto = array(
                    "id" => $linha[0],
                    "nome" => $linha[1],
                    "categoria" => $linha[2],
                    "is_emprestado" => $linha[3]
                );
                array_push($array_produtos,$array_produto);
            }
        }
        desconectar($conexao);
        return $array_produtos;
    }

    function pegarProduto($id){
        $array_produto = array();
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $stmt = $conexao->query("SELECT id, nome, id_categoria, id_usuario FROM produtos WHERE id = '$id'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();    
            $array_produto = array(
                "id" => $linha[0],
                "nome" => $linha[1],
                "categoria" => $linha[2],
                "id_usuario" => $linha[3]
            );
        }
        desconectar($conexao);
        return $array_produto;
    }

    function pegarProdutosEmprestados($idUsuario){
        $array_produtos = array();
        $conexao = conectar();
        $idUsuario = $conexao->real_escape_string($idUsuario);
        $stmt =  $conexao->query("SELECT p.id, "
                                ."p.nome, "
                                ."p.id_categoria, "
                                ."p.is_emprestado, "
                                ."e.id as id_emprestimo " 
                                ."FROM produtos as p, emprestimos as e "
                                ."WHERE p.id_usuario = '$idUsuario' "
                                ."AND p.is_emprestado = 1 "
                                ."AND e.id_produto = p.id "
                                ."AND e.status = 0");
        
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_produto = array(
                    "id" => $linha[0],
                    "nome" => $linha[1],
                    "categoria" => $linha[2],
                    "is_emprestado" => $linha[3],
                    "id_emprestimo" => $linha[4]
                );
                array_push($array_produtos,$array_produto);
            }
        }
        desconectar($conexao);
        return $array_produtos;
    }

    function pegarProdutosNaoEmprestados($idUsuario){
        $array_produtos = array();
        $conexao = conectar();
        $idUsuario = $conexao->real_escape_string($idUsuario);
        $stmt =  $conexao->query("SELECT id, nome, id_categoria, is_emprestado FROM produtos WHERE id_usuario = '$idUsuario' AND is_emprestado = 0");
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_produto = array(
                    "id" => $linha[0],
                    "nome" => $linha[1],
                    "categoria" => $linha[2],
                    "is_emprestado" => $linha[3]
                );
                array_push($array_produtos,$array_produto);
            }
        }
        desconectar($conexao);
        return $array_produtos;
    }

    function isProdutoEmprestado($id){
        $retorno = false;
        $conexao = conectar();
        $stmt = $conexao->query("SELECT 1 FROM emprestimos WHERE id_produto = '$id' and status = 0");
        if($stmt->num_rows > 0){
            $retorno = true;
        }
        desconectar($conexao);
        return $retorno;
    }

    function excluirProduto($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        define("SQL_DELETE", "DELETE FROM produtos WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_DELETE"));
        $stmt->bind_param('i', $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function editarProduto($nome, $idCategoria, $id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $nome = $conexao->real_escape_string($nome);
        $idCategoria = $conexao->real_escape_string($idCategoria);
        
        define("SQL_UPDATE", "UPDATE produtos SET nome = ?, id_categoria = ? WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE"));
        $stmt->bind_param('sii', $nome, $idCategoria, $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function emprestarProduto($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        
        define("SQL_UPDATE_LOAN", "UPDATE produtos SET is_emprestado = 1 WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE_LOAN"));
        $stmt->bind_param('i', $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function devolverProduto($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        
        define("SQL_UPDATE_REFUND", "UPDATE produtos SET is_emprestado = 0 WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE_REFUND"));
        $stmt->bind_param('i', $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function inserirProduto($nome, $idCategoria, $idUsuario){
        $retorno = false;
        $conexao = conectar();
        $nome = $conexao->real_escape_string($nome);
        $idCategoria = $conexao->real_escape_string($idCategoria);
        $idUsuario = $conexao->real_escape_string($idUsuario);

        define("SQL_INSERT", "INSERT INTO produtos (nome, id_categoria, id_usuario) VALUES(?, ?, ?)");
        $stmt = $conexao->prepare(constant("SQL_INSERT"));
        $stmt->bind_param('sii', $nome, $idCategoria, $idUsuario);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }
?>