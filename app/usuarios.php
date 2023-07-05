<?php
    include_once 'conexao.php';

    function pegarTodosUsuarios(){
        $array_usuarios = array();
        $conexao = conectar();
        $stmt = $conexao->query("SELECT id, nome, usuario, tipo_usuario FROM usuarios");
        if($stmt->num_rows > 0){
            while($linha = $stmt->fetch_row()){
                $array_usuario = array(
                    "id" => $linha[0],
                    "nome" => $linha[1],
                    "usuario" => $linha[2],
                    "tipo_usuario" => $linha[3]
                );
                array_push($array_usuarios, $array_usuario);
            }
        }
        desconectar($conexao);
        return $array_usuarios;
    }

    function pegarUsuario($id){
        $array_usuario = array();
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $stmt = $conexao->query("SELECT id, nome, usuario, tipo_usuario FROM usuarios where id = '$id'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();
            $array_usuario = array(
                "id" => $linha[0],
                "nome" => $linha[1],
                "usuario" => $linha[2],
                "tipo_usuario" => $linha[3]
            );
        }
        desconectar($conexao);
        return $array_usuario;
    }

    function pegarUsuarioPorUsuario($usuario){
        $array_usuario = array();
        $conexao = conectar();
        $usuario = $conexao->real_escape_string($usuario);
        $stmt = $conexao->query("SELECT id, nome, usuario, tipo_usuario FROM usuarios where usuario = '$usuario'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();
            $array_usuario = array(
                "id" => $linha[0],
                "nome" => $linha[1],
                "usuario" => $linha[2],
                "tipo_usuario" => $linha[3]
            );
        }
        desconectar($conexao);
        return $array_usuario;
    }

    function excluirUsuario($id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        define("SQL_DELETE", "DELETE FROM usuarios WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_DELETE"));
        $stmt->bind_param('i', $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function editarUsuario($nome, $usuario, $tipoUsuario, $id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $nome = $conexao->real_escape_string($nome);
        $usuario = $conexao->real_escape_string($usuario);
        $tipoUsuario = $conexao->real_escape_string($tipoUsuario);
        define("SQL_UPDATE", "UPDATE usuarios SET nome = ?, usuario = ?, tipo_usuario = ? WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE"));
        $stmt->bind_param('ssii', $nome, $usuario, $tipoUsuario, $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function editarSenha($senha, $id){
        $retorno = false;
        $conexao = conectar();
        $id = $conexao->real_escape_string($id);
        $senha = $conexao->real_escape_string($senha);
        
        define("SQL_UPDATE_PASS", "UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt = $conexao->prepare(constant("SQL_UPDATE_PASS"));
        $stmt->bind_param('si', $senha, $id);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function inserirUsuario($nome, $usuario, $senha, $tipoUsuario){
        $retorno = false;
        $conexao = conectar();
        $nome = $conexao->real_escape_string($nome);
        $usuario = $conexao->real_escape_string($usuario);
        $senha = $conexao->real_escape_string($senha);
        $tipoUsuario = $conexao->real_escape_string($tipoUsuario);

        define("SQL_INSERT", "INSERT INTO usuarios (nome, usuario, senha, tipo_usuario) VALUES (?,?,?,?)");
        $stmt = $conexao->prepare(constant("SQL_INSERT"));
        $stmt->bind_param('sssi', $nome, $usuario, $senha, $tipoUsuario);
        $retorno = $stmt->execute();
        desconectar($conexao);
        return $retorno;
    }

    function login($usuario, $senha){
        $array_usuario = array();
        $conexao = conectar();

        $usuario = $conexao->real_escape_string($usuario);
        $senha = $conexao->real_escape_string($senha);

        $stmt = $conexao->query("SELECT id, nome, usuario, tipo_usuario FROM usuarios where usuario = '$usuario' AND senha = '$senha'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();
            $array_usuario = array(
                "id" => $linha[0],
                "nome" => $linha[1],
                "usuario" => $linha[2],
                "tipo_usuario" => $linha[3]
            );
        }
        desconectar($conexao);
        return $array_usuario;
    }
?>