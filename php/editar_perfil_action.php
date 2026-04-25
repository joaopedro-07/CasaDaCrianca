<?php
session_start();
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['admin_id'];
    $telefone = $_POST['telefone'];
    $genero = $_POST['genero'];
    
    // Se o usuário digitou algo na nova senha
    if (!empty($_POST['nova_senha'])) {
        $senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
        $sql = "UPDATE administradores SET telefone = ?, genero = ?, senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $telefone, $genero, $senha, $id);
    } else {
        // Se não digitou senha, atualiza só o resto
        $sql = "UPDATE administradores SET telefone = ?, genero = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $telefone, $genero, $id);
    }

    if ($stmt->execute()) {
        header("Location: perfil.php?atualizado=1");
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}