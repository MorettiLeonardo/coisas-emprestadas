<?php
    define("SERVIDOR", "Localhost");
    define('USUARIO', "root");
    define("SENHA", "1234");
    define("BANCO", "coisas_emprestadas");
    
    function conectar(){
        $conexao = new mysqli(constant("SERVIDOR"), constant("USUARIO"), constant("SENHA"), constant("BANCO"));
        return $conexao;
    }

    function desconectar($conexao){
        return $conexao->close();
    }

?>
