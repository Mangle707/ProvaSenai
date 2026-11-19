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

        $idade = filter_var(
            $_POST["idade"] ?? null,
            FILTER_VALIDATE_INT
        );

        $salario = filter_var(
            $_POST["salario"] ?? null,
            FILTER_VALIDATE_FLOAT
        );

        $cargo = $_POST["cargo"] ?? "";

        if ($idade === false || $idade === null) {
            throw new InvalidArgumentException("Idade invalida!");
        }

        if ($salario === false || $salario === null) {
            throw new InvalidArgumentException("Salario invalido!");
        }

        if ($cargo == "operador") {

            $funcionario = new Operador(
                $nome,
                $idade,
                $salario
            );

        } elseif ($cargo == "supervisor") {

            $funcionario = new Supervisor(
                $nome,
                $idade,
                $salario
            );

        } else {

            throw new InvalidArgumentException("Cargo inválido!");

        }

        $sql = "UPDATE funcionarios SET

                nome = :nome,

                idade = :idade,

                salario = :salario,

                cargo = :cargo

                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([

            ":nome" => $funcionario->getNome(),

            ":idade" => $funcionario->getIdade(),

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

        <label>Idade:</label>

        <input
            type="number"
            name="idade"
            value="<?= h($dados["idade"]) ?>"
            min="1"
            required
        >

        <br><br>

        <label>Salário:</label>

        <input
            type="number"
            name="salario"
            value="<?= h($dados["salario"]) ?>"
            step="0.01"
            min="0"
            required
        >

        <br><br>

        <label>Cargo:</label>

        <select name="cargo" required>

            <option
                value="operador"
                <?= $dados["cargo"] == "operador" ? "selected" : "" ?>
            >
                Operador
            </option>

            <option
                value="supervisor"
                <?= $dados["cargo"] == "supervisor" ? "selected" : "" ?>
            >
                Supervisor
            </option>

        </select>

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>

    <a href="listar.php">Voltar</a>

</body>

</html>