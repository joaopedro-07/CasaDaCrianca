<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
require_once '../conexao.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$id = $_SESSION['admin_id'];
$sql = "SELECT nome, email, cpf, genero, telefone FROM administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$admin = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="../styles/perfil.css">
    <title>Perfil de Usuário - Casa da Criança</title>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="content">
            <div class="top-header" style="display: flex; justify-content: flex-end; align-items: center; gap: 20px; margin-bottom: 20px;">
                <button type="button" onclick="abrirModal('modalCadastro')" class="btn-novo-adm" style="background: #ffc107; color: white; padding: 10px 15px; border-radius: 10px; border:none; cursor:pointer; font-weight: bold; font-size: 13px;">
                    <i class="fa-solid fa-user-plus"></i> Novo Administrador
                </button>
                <a href="logout.php" onclick="return confirm('Sair do sistema?')" class="logout-icon" style="font-size: 24px; color: #333;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>

            <h1 style="margin-bottom: 30px;">Perfil de Usuário</h1>

            <div class="profile-header" style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
                <div class="user-avatar" style="font-size: 70px; color: #000;">
                    <i class="fa-solid fa-circle-user"></i>
                </div>
                <div class="user-names">
                    <h2 style="font-size: 22px; margin: 0;"><?php echo $admin['nome']; ?></h2>
                    <p style="color: #666; margin: 5px 0;"><?php echo $admin['email']; ?></p>
                </div>
                <button type="button" onclick="abrirModal('modalEdicao')" class="btn-editar" style="background: #4a90e2; color: white; padding: 10px 25px; border-radius: 8px; border:none; cursor:pointer; font-weight: bold; margin-left: 20px;">Editar Perfil</button>
            </div>

            <div class="profile-grid">
                <div class="field-group"><label>Nome</label><input type="text" value="<?php echo $admin['nome']; ?>" readonly></div>
                <div class="field-group"><label>Email</label><input type="text" value="<?php echo $admin['email']; ?>" readonly></div>
                <div class="field-group"><label>Gênero</label><input type="text" value="<?php echo $admin['genero']; ?>" readonly></div>
                <div class="field-group"><label>Senha</label><input type="text" value="****************" readonly></div>
                <div class="field-group"><label>CPF</label><input type="text" value="<?php echo $admin['cpf']; ?>" readonly></div>
                <div class="field-group"><label>Telefone</label><input type="text" value="<?php echo $admin['telefone']; ?>" readonly></div>
            </div>

            <div class="danger-zone">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Zona de Exclusão</h3>
                <p>Cuidado! Ao clicar no botão abaixo, sua conta será removida permanentemente.</p>
                <a href="excluir_conta.php" class="btn-excluir" onclick="return confirm('Deseja realmente EXCLUIR sua conta?')">Excluir Conta</a>
            </div>
        </main>
    </div>

    <div id="modalCadastro" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="fecharModal('modalCadastro')">&times;</span>
            <h2>Novo Administrador</h2>
            <form action="cadastrar_adm_action.php" method="POST">
                <div class="field-group"><label>Nome</label><input type="text" name="nome" required></div>
                <div class="field-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="field-group"><label>CPF</label><input type="text" name="cpf" required></div>
                
                <div class="field-group">
                    <label>Gênero</label>
                    <select name="genero" style="width:100%; padding:10px; border-radius:8px;" required>
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                        <option value="Prefiro não dizer">Prefiro não dizer</option>
                    </select>
                </div>
                <div class="field-group"><label>Telefone</label><input type="text" name="telefone" required></div>
                
                <div class="field-group"><label>Senha</label><input type="password" name="senha" required></div>
                <button type="submit" class="btn-salvar-modal" style="background:#ffc107">Cadastrar</button>
            </form>
        </div>
    </div>

    <div id="modalEdicao" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="fecharModal('modalEdicao')">&times;</span>
            <h2>Editar Meus Dados</h2>
            <form action="editar_perfil_action.php" method="POST">
                <div class="field-group"><label>Telefone</label><input type="text" name="telefone" value="<?php echo $admin['telefone']; ?>"></div>
                <div class="field-group">
                    <label>Gênero</label>
                    <select name="genero" style="width:100%; padding:10px; border-radius:8px;">
                        <option value="Masculino" <?php echo ($admin['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Feminino" <?php echo ($admin['genero'] == 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                        <option value="Outro" <?php echo ($admin['genero'] == 'Outro') ? 'selected' : ''; ?>>Outro</option>
                        <option value="Prefiro não dizer" <?php echo ($admin['genero'] == 'Prefiro não dizer') ? 'selected' : ''; ?>>Prefiro não dizer</option>
                    </select>
                </div>
                <div class="field-group"><label>Nova Senha (opcional)</label><input type="password" name="nova_senha"></div>
                <button type="submit" class="btn-salvar-modal">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(id) { document.getElementById(id).style.display = "flex"; }
        function fecharModal(id) { document.getElementById(id).style.display = "none"; }
        window.onclick = function(e) { if(e.target.className === "modal") e.target.style.display = "none"; }
    </script>
</body>
</html>