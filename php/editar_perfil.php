<?php
include 'verificar_login.php';

// IMPEDIR CACHE (Coloque isso em todas as páginas do diretório /php)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$id = $_SESSION['admin_id'];

// Busca dados atuais
$sql = "SELECT genero, telefone FROM administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    
    // Se preencher a senha, atualiza ela com hash. Se não, mantém a antiga.
    if (!empty($_POST['nova_senha'])) {
        $senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
        $sql_update = "UPDATE administradores SET genero = ?, telefone = ?, senha = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $genero, $telefone, $senha, $id);
    } else {
        $sql_update = "UPDATE administradores SET genero = ?, telefone = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssi", $genero, $telefone, $id);
    }

    if($stmt_update->execute()) {
        header("Location: perfil.php?atualizado=1");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Editar Perfil</title>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'sidebar.php'; ?>
        <main class="content">
            <h2>Editar Meu Perfil</h2>
            <form method="POST" style="max-width: 400px; margin-top: 20px;">
                <label>Gênero:</label>
                <select name="genero" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                    <option value="Masculino" <?php if($admin['genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                    <option value="Feminino" <?php if($admin['genero'] == 'Feminino') echo 'selected'; ?>>Feminino</option>
                    <option value="Outro" <?php if($admin['genero'] == 'Outro') echo 'selected'; ?>>Outro</option>
                </select>

                <label>Telefone:</label>
                <input type="text" name="telefone" value="<?php echo $admin['telefone']; ?>" style="width: 100%; margin-bottom: 10px; padding: 8px;">

                <label>Nova Senha (deixe em branco para não alterar):</label>
                <input type="password" name="nova_senha" style="width: 100%; margin-bottom: 10px; padding: 8px;">

                <button type="submit" style="background: orange; color: white; padding: 10px 20px; border: none; cursor: pointer;">Atualizar Dados</button>
            </form>
        </main>
    </div>
</body>
</html>