<?php
session_start();
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // SQL com os 6 campos
    $sql = "INSERT INTO administradores (nome, email, cpf, genero, telefone, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vincula os 6 parâmetros (todos strings)
    $stmt->bind_param("ssssss", $nome, $email, $cpf, $genero, $telefone, $senha);
    
    if ($stmt->execute()) {
        header("Location: perfil.php?sucesso=1");
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}
?>