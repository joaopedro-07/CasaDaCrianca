<?php
$sql = "SELECT id, nome FROM administradores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_logado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $linha = mysqli_fetch_assoc($resultado);
}
?>
<header class="header">
    <a class='user-profile-link' href="perfil.php">
        <div class="user-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FCC404" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
        </div>
        <div class="user-text">
            <span class="name">
                <?php echo $linha ? htmlspecialchars($linha['nome']) : 'Admin'; ?>
            </span>
        </div>
    </a>
</header>