<?php
    include_once 'conexao.php';

    function pegarSlugTipoUsuario($tipo){
        $slug = "";
        $conexao = conectar();
        $tipo = $conexao->real_escape_string($tipo);
        $stmt = $conexao->query("SELECT slug FROM tipo_usuarios where tipo = '$tipo'");
        if($stmt->num_rows > 0){
            $linha = $stmt->fetch_row();
            $slug = $linha[0];
        }
        desconectar($conexao);
        return $slug;
    }
?>