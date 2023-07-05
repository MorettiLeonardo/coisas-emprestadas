<?php
    include_once 'conexao.php';

    function pegarTodasCategorias($idUsuario){
        $array_categorias = array();
        $conexao = conectar();
        $idUsuario = $conexao->real_escape_string($idUsuario);
        $stmt = $conexao->query("SELECT id, slug FROM categorias WHERE id_usuario = '$idUsuario'");
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_categoria = array(
                    "id" => $linha[0],
                    "slug" => $linha[1]
                );

                array_push($array_categorias, $array_categoria);
            }
        }
        desconectar($conexao);
        return $array_categorias;
    }

    function pegarCategoria($id){
        $array_categoria = array();
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $stmt = $conexao->query("SELECT id, slug, id_usuario FROM categorias WHERE id = '$id'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();    
            $array_categoria = array(
                "id" => $linha[0],
                "slug" => $linha[1],
                "id_usuario" => $linha[2]
            );
        }
        desconectar($conexao);
        return $array_categoria;
    }

    function excluirCategoria($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        define("SQL_DELETE", "DELETE FROM categorias WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_DELETE"));
        $stmt->bind_param('i', $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function editarCategoria($slug, $id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $slug = $conexao->real_escape_string($slug);
        
        define("SQL_UPDATE", "UPDATE categorias SET slug = ? WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE"));
        $stmt->bind_param('si', $slug, $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function inserirCategoria($slug, $idUsuario){
        $retorno = false;
        $conexao = conectar();
        $slug = $conexao->real_escape_string($slug);
        define("SQL_INSERT", "INSERT INTO categorias (slug, id_usuario) VALUES(?, ?)");
        $stmt = $conexao->prepare(constant("SQL_INSERT"));
        $stmt->bind_param('si', $slug, $idUsuario);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

?>