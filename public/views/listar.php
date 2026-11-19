<?php
require_once __DIR__ . "/config/conexao.php";
require_once __DIR__ . "/config/funcoes.php";
require_once __DIR__ . "/models/FuncionarioC.php";
require_once __DIR__ . "/models/Gerente.php";

if(isset($_GET["id"]) && $_GET["id"]!=="")
    {
        $id = filter_var($_GET["id"],FILTER_VALIDATE_INT);

        if($id === false || $id<=0){
            die("ID invalido");
        }
        $sql = "SELECT*FROM funcionarios WHERE id=: id";
        $stmt = $pdo->prepare($sql);

        $stmt-> execute([
            ":id" => $id ]);
        $funcionarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
else{
    $sql="SELECT*FROM funcionarios ORDER BY id DESC";
    $stmt=$pdo->query($sql);

    $funcionarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de funcionarios</title>
</head>
<body>
    <h1>Gerenciamento de funcionarios</h1>
    <a href = "cadastrar.php">Cadastrar funcionarios</a>

    <h2>Pesquisar pelo ID</h2>
    <form action="listar.php" method="GET">
        <input
           type="number"
           name="id"
           placeholder="Digite o ID"
           min="1"
        >
        <button type="submit">Perquisar</button>
    </form>
     <br>
    <h2>lista de funcionarios</h2>
    <table lorder="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Funcao</th>
            <th>Salario</th>
        </tr>
        <?php foreach($funcionarios as $funcionario):?>
        <?php
         if($funcionario["Cargo"]=="operador"){
            $objeto=new FuncionarioComum(
                $funcionario["nome"],
                (string)$funcionario["Email"],
                (float)$funcionario["salario"]
            );           
         } else {
            $objeto = new Gerente(
                $funcionario["nome"],
                (string)$funcionario["Email"],
                (float)$funcionario["salario"]
            );
         }
        ?>
        <tr>
            <td><?= h($funcionario["id"])  ?></td>
            <td><?= h($objeto->getNome())  ?></td>
            <td><?= h($objeto->getEmail())  ?></td>
            <td><?= h($objeto->getCargo())  ?></td>
            <td><?= h($objeto->executarFuncao())  ?></td>
            <td><?= number_format($objeto->getSalario())  ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php if(count($funcionario) == 0): ?>
        <p>Nenhum funcionario encontrado</p>
        <?php endif;?>
</body>
</html>