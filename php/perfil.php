<?php
include 'verificar_login.php';

// Busca os dados do administrador logado (tudo ligado ao usuário da sessão)
$sql = "SELECT nome, email, cpf, genero, telefone FROM administradores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_logado);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($resultado);

// Iniciais para o avatar
$nomeAdmin = $admin['nome'] ?? 'Admin';
$partes = preg_split('/\s+/', trim($nomeAdmin));
$iniciais = strtoupper(substr($partes[0], 0, 1) . (isset($partes[1]) ? substr($partes[1], 0, 1) : ''));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Perfil - Casa da Criança</title>
</head>

<body class="body-padrao">
    <?php include 'sidebar.php'; ?>

    <div class="container-geral">
        <?php include 'header.php'; ?>

        <main class="main-perfil">
            <div class="perfil-wrapper">

                <!-- Cartão principal do perfil -->
                <section class="card-perfil">
                    <div class="card-perfil-topo"></div>

                    <div class="perfil-identidade">
                        <div class="perfil-avatar"><?php echo htmlspecialchars($iniciais); ?></div>
                        <div class="perfil-nome-bloco">
                            <h1 class="perfil-nome"><?php echo htmlspecialchars($nomeAdmin); ?></h1>
                            <p class="perfil-email"><?php echo htmlspecialchars($admin['email'] ?? ''); ?></p>
                            <span class="perfil-tag"><i class="fa-solid fa-shield-halved"></i> Administrador</span>
                        </div>
                        <div class="perfil-acoes">
                            <button type="button" class="btn-perfil btn-perfil-amarelo" onclick="abrirModal('modalCadastro')">
                                <i class="fa-solid fa-user-plus"></i> Novo Administrador
                            </button>
                            <button type="button" class="btn-perfil btn-perfil-escuro" onclick="abrirModal('modalEdicao')">
                                <i class="fa-solid fa-pen"></i> Editar Perfil
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Informações pessoais -->
                <section class="card-info">
                    <h2 class="card-info-titulo"><i class="fa-solid fa-id-card"></i> Informações Pessoais</h2>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-user"></i> Nome</span>
                            <span class="info-valor"><?php echo htmlspecialchars($admin['nome'] ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-envelope"></i> E-mail</span>
                            <span class="info-valor"><?php echo htmlspecialchars($admin['email'] ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-venus-mars"></i> Gênero</span>
                            <span class="info-valor"><?php echo htmlspecialchars($admin['genero'] ?: '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-phone"></i> Telefone</span>
                            <span class="info-valor"><?php echo htmlspecialchars($admin['telefone'] ?: '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-address-card"></i> CPF</span>
                            <span class="info-valor"><?php echo htmlspecialchars($admin['cpf'] ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa-solid fa-lock"></i> Senha</span>
                            <span class="info-valor">••••••••••••</span>
                        </div>
                    </div>
                </section>

                <!-- Zona de exclusão -->
                <section class="card-perigo">
                    <div class="perigo-texto">
                        <h3><i class="fa-solid fa-triangle-exclamation"></i> Zona de Exclusão</h3>
                        <p>Ao excluir sua conta, todos os seus dados de acesso serão removidos permanentemente.</p>
                    </div>
                    <a href="excluir_conta.php" class="btn-excluir-conta" id="btnExcluir">Excluir Conta</a>
                </section>

            </div>
        </main>
    </div>

    <!-- Modal: Novo Administrador -->
    <div id="modalCadastro" class="modal-perfil">
        <div class="modal-perfil-conteudo">
            <button class="modal-fechar" onclick="fecharModal('modalCadastro')">&times;</button>
            <h2 class="modal-titulo"><i class="fa-solid fa-user-plus"></i> Novo Administrador</h2>
            <form action="cadastrar_adm_action.php" method="POST" class="modal-form">
                <div class="modal-campo"><label>Nome</label><input type="text" name="nome" placeholder="Nome completo" required></div>
                <div class="modal-campo"><label>E-mail</label><input type="email" name="email" placeholder="email@exemplo.com" required></div>
                <div class="modal-campo"><label>CPF</label><input type="text" name="cpf" placeholder="000.000.000-00" required></div>
                <div class="modal-campo">
                    <label>Gênero</label>
                    <select name="genero" required>
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                        <option value="Prefiro não dizer">Prefiro não dizer</option>
                    </select>
                </div>
                <div class="modal-campo"><label>Telefone</label><input type="text" name="telefone" placeholder="(00) 00000-0000" required></div>
                <div class="modal-campo"><label>Senha</label><input type="password" name="senha" placeholder="Crie uma senha" required></div>
                <button type="submit" class="btn-modal-salvar btn-modal-amarelo">Cadastrar Administrador</button>
            </form>
        </div>
    </div>

    <!-- Modal: Editar Perfil -->
    <div id="modalEdicao" class="modal-perfil">
        <div class="modal-perfil-conteudo">
            <button class="modal-fechar" onclick="fecharModal('modalEdicao')">&times;</button>
            <h2 class="modal-titulo"><i class="fa-solid fa-pen"></i> Editar Meus Dados</h2>
            <form action="editar_perfil_action.php" method="POST" class="modal-form">
                <div class="modal-campo">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="<?php echo htmlspecialchars($admin['telefone'] ?? ''); ?>">
                </div>
                <div class="modal-campo">
                    <label>Gênero</label>
                    <select name="genero">
                        <?php
                        $generos = ['Masculino', 'Feminino', 'Outro', 'Prefiro não dizer'];
                        foreach ($generos as $g) {
                            $sel = ($admin['genero'] ?? '') === $g ? 'selected' : '';
                            echo "<option value=\"$g\" $sel>$g</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-campo">
                    <label>Nova Senha <span class="campo-opcional">(opcional)</span></label>
                    <input type="password" name="nova_senha" placeholder="Deixe em branco para manter a atual">
                </div>
                <button type="submit" class="btn-modal-salvar btn-modal-escuro">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        // Disponibiliza o status de atualização para o JS exibir o alerta de sucesso
        window.PERFIL_ATUALIZADO = <?php echo isset($_GET['atualizado']) ? 'true' : 'false'; ?>;
    </script>
    <script src="../js/perfil.js" defer></script>
</body>

</html>
