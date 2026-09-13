<?php
include 'verificar_login.php';

$sql = "SELECT id, nome FROM administradores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_logado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $linha = mysqli_fetch_assoc($resultado);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Suporte - Casa da Criança</title>
</head>
<body class="body-padrao">
    <?php include 'sidebar.php'; ?>
    <div class="container-geral">
        <?php include 'header.php'; ?>  
    </div>
</body>
</html>