<?php
require_once __DIR__ . "/config/conexao.php";
require_once __DIR__ . "/config/funcoes.php";
require_once __DIR__ . "/models/FuncionarioC.php";
require_once __DIR__ . "/models/Gerente.php";

$mensagem = "";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        $nome=trim($_POST["nome"] ?? "");
        $idade = filter_var(
            $_POST["idade"] ?? null,
            FILTER_VALIDATE_INT
        );
        $salario = filter_var(
            $_POST["salario"] ?? null
        )
    }
  }

?>