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
            $_POST["salario"] ?? null,
            FILTER_VALIDATE_FLOAT
        );
        $cargo = $_POST["cargo"] ?? "";

        if($salario === false || $salario === null){
            throw new InvalidArgumentException("Salario invalido");
        }

        if($cargo == "gerente"){
            $funcionario = new Gerente(
                $nome,
                $email,
                $salario
            );
        }
        if($cargo == "funcionarioComum"){
            $funcionario = new FuncionarioComum(
                $nome,
                $email,
                $salario
            );
        }else{
            throw new InvalidArgumentException("cargo invalido");
        }
        $sql = "INSERT INTO funcionarios
               (nome,idade,salario,cargo)
               VALUES
               (:nome,:idade,:salario,:cargo)";

       $stmt = $pdo ->prepare($sql);

       $stmt ->execute([
        ":nome"=>$funcionario->getNome(),
        ":email"=>$funcionario->getEmail(),
        ":salario"=>$funcionario->getSalario(),
        ":cargo"=>$funcionario->getCargo(),
       ]);
       header("Location:lista.php");
       exit; }

       catch(PDOException | InvalidArgumentException $e){
        $mensagem = "Erro ao cadastrar:" . $e -> getMessage();
       }
  }

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionarios</title>
</head>
<body>
    <h1>Cadarstrar Funcionario</h1>
    <p><?= h($mensagem) ?></p>

    <form action = "cadastrar.php" method="POST">
        <label>Nome:</label>
        <input type = "text" name="nome" required>

         <label>Email:</label>
        <input type = "text" name="email" required>

         <label>Salario:</label>
        <input type = "number" name="salario" min=100 required>

        <label>Cargo:</label>
        <select name="cargo" required>
            <option value=" ">Selecione</option>
            <option value="funcionarioComum">Funcionario Comum</option>
            <option value="gerente">Gerente</option>
        </select>
<br>
        <button type="submit">Cadastrar</button>

    </form>
</body>
</html>