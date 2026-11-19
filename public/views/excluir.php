<?php

require_once __DIR__ . "../config/conexao.php";
require_once __DIR__ . "../config/funcoes.php";

$id = filter_var(
    $_GET["id"] ?? $_POST["id"] ?? null,
    FILTER_VALIDATE_INT
);

if ($id === false || $id === null || $id <= 0) {

    die("ID inválido!");

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "DELETE FROM funcionarios WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    header("Location: listar.php");

    exit;

}

$sql = "SELECT * FROM funcionarios WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {

    die("Funcionário não encontrado!");

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Excluir Funcionário</title>

</head>

<body>

    <h1>Excluir Funcionário</h1>

    <p>
        Tem certeza que deseja excluir
        <?= h($funcionario["nome"]) ?>?
    </p>

    <form action="excluir.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= h($id) ?>"
        >

        <button type="submit">Confirmar exclusão</button>

    </form>

    <br>

    <a href="listar.php">Cancelar</a>

</body>

</html>