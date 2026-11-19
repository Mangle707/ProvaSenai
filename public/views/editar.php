<?php

require_once __DIR__ . "../config/conexao.php";
require_once __DIR__ . "../config/funcoes.php";
require_once __DIR__ . "/models/FuncionarioC.php";
require_once __DIR__ . "/models/Gerente.php";

$id = filter_var(
    $_GET["id"] ?? null,
    FILTER_VALIDATE_INT
);

if ($id === false || $id === null || $id <= 0) {

    die("ID invalido!");

}

$sql = "SELECT * FROM funcionarios WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {

    die("Funcionario nao encontrado!");

}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $nome = trim($_POST["nome"] ?? "");
         $email = trim($_POST["email"] ?? "");


        $salario = filter_var(
            $_POST["salario"] ?? null,
            FILTER_VALIDATE_FLOAT
        );

        $cargo = $_POST["cargo"] ?? "";

        if ($email === false || $email === null) {
            throw new InvalidArgumentException("Email invalido!");
        }

        if ($salario === false || $salario === null) {
            throw new InvalidArgumentException("Salario invalido!");
        }

        if ($cargo == "funcionarioComum") {

            $funcionario = new FuncionarioComum(
                $nome,
                $email,
                $salario
            );

        } elseif ($cargo == "gerente") {

            $funcionario = new Gerente(
                $nome,
                $email,
                $salario
            );

        } else {

            throw new InvalidArgumentException("Cargo invalido!");

        }

        $sql = "UPDATE funcionarios SET

                nome = :nome,

                email = :email,

                salario = :salario,

                cargo = :cargo

                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([

            ":nome" => $funcionario->getNome(),

            ":email" => $funcionario->getEmail(),

            ":salario" => $funcionario->getSalario(),

            ":cargo" => $funcionario->getCargo(),

            ":id" => $id

        ]);

        header("Location: listar.php");

        exit;

    } catch (PDOException | InvalidArgumentException $e) {

        $mensagem = "Erro ao atualizar: " . $e->getMessage();

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Editar Funcionário</title>

</head>

<body>

    <h1>Editar Funcionário</h1>

    <p><?= h($mensagem) ?></p>

    <form action="editar.php?id=<?= h($id) ?>" method="POST">

        <label>Nome:</label>

        <input
            type="text"
            name="nome"
            value="<?= h($dados["nome"]) ?>"
            required
        >

        <br><br>

        <label>Email:</label>

        <input
            type="text"
            name="email"
            value="<?= h($dados["email"]) ?>"
            required
        >

        <br><br>

        <label>Salário:</label>

        <input
            type="number"
            name="salario"
            value="<?= h($dados["salario"]) ?>"

            min="0"
            required
        >

        <br><br>

        <label>Cargo:</label>

        <select name="cargo" required>

            <option
                value="funcionarioComum"
                <?= $dados["cargo"] == "funcionarioComum" ? "selected" : "" ?>
            >
                Funcionario Comum
            </option>

            <option
                value="gerente"
                <?= $dados["cargo"] == "gerente" ? "selected" : "" ?>
            >
                Gerente
            </option>

        </select>

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>

    <a href="listar.php">Voltar</a>

</body>

</html>