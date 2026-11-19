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
    
</body>
</html>