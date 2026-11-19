<?php 
    $host = "localhost";
    $dbname = "empresa_db";
    $usuario = "root";
    $senha = "";

    try {//como um if else 
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
             $usuario,
             $senha
        );
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }catch(PDOException $e){
        die("Erro na conexao" . $e->getMessage());
    }
?>